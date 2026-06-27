#!/bin/bash
set -e

# =============================================================
# STEP 1: Parse database URL from Railway environment variables
# =============================================================
DB_URL="${DATABASE_URL:-${MYSQL_URL:-$MYSQL_PUBLIC_URL}}"

if [ -z "$DB_URL" ]; then
  echo "=========================================="
  echo " ERROR: No database URL found!"
  echo ""
  echo " Set one of these in Railway Variables:"
  echo "   DATABASE_URL"
  echo "   MYSQL_URL       (auto-set by MySQL plugin)"
  echo ""
  echo " Current values:"
  echo "   DATABASE_URL='${DATABASE_URL}'"
  echo "   MYSQL_URL='${MYSQL_URL}'"
  echo "   MYSQL_PUBLIC_URL='${MYSQL_PUBLIC_URL}'"
  echo "=========================================="
  exit 1
fi

export DATABASE_URL="$DB_URL"

# Parse URL components
# Format: mysql://user:password@host:port/database
DB_USERNAME=$(echo "$DB_URL" | sed -n 's|mysql://\([^:]*\):.*|\1|p')
DB_PASSWORD=$(echo "$DB_URL" | sed -n 's|mysql://[^:]*:\([^@]*\)@.*|\1|p')
DB_HOST=$(echo "$DB_URL"     | sed -n 's|mysql://[^@]*@\([^:/]*\).*|\1|p')
DB_PORT=$(echo "$DB_URL"     | sed -n 's|mysql://[^@]*@[^:/]*:\([^/]*\)/.*|\1|p')
DB_DATABASE=$(echo "$DB_URL" | sed -n 's|.*/\([^?]*\)|\1|p')

[ -z "$DB_PORT" ] && DB_PORT="3306"

export DB_CONNECTION=mysql
[ -n "$DB_USERNAME" ] && export DB_USERNAME  || true
[ -n "$DB_PASSWORD" ] && export DB_PASSWORD  || true
[ -n "$DB_HOST" ]     && export DB_HOST      || true
[ -n "$DB_PORT" ]     && export DB_PORT      || true
[ -n "$DB_DATABASE" ] && export DB_DATABASE  || true

# =============================================================
# STEP 2: Validate parsed values
# =============================================================
if [ -z "$DB_HOST" ] || [ -z "$DB_DATABASE" ]; then
  echo "=========================================="
  echo " ERROR: Failed to parse database URL."
  echo ""
  echo " URL:  $DB_URL"
  echo ""
  echo " Parsed values:"
  echo "   DB_HOST:      '${DB_HOST}'"
  echo "   DB_PORT:      '${DB_PORT}'"
  echo "   DB_DATABASE:  '${DB_DATABASE}'"
  echo "   DB_USERNAME:  '${DB_USERNAME}'"
  echo "=========================================="
  exit 1
fi

# =============================================================
# STEP 3: Log database config
# =============================================================
DB_URL_MASKED=$(echo "$DB_URL" | sed 's|://[^:]*:[^@]*@|://***:***@|')
echo "=========================================="
echo " Database URL:  ${DB_URL_MASKED}"
echo " DB_HOST:       ${DB_HOST}"
echo " DB_PORT:       ${DB_PORT}"
echo " DB_DATABASE:   ${DB_DATABASE}"
echo " DB_USERNAME:   ${DB_USERNAME}"
echo "=========================================="

# =============================================================
# STEP 4: DNS resolution test
# =============================================================
echo "Testing DNS resolution for '${DB_HOST}'..."
HOST_IP=$(getent hosts "${DB_HOST}" 2>/dev/null | awk '{ print $1 }' | head -1)
if [ -n "$HOST_IP" ]; then
  echo "  -> Resolved to: ${HOST_IP}"
else
  echo "  -> WARNING: DNS resolution failed!"
fi

# =============================================================
# STEP 5: TCP connectivity test
# =============================================================
echo "Testing TCP connection to ${DB_HOST}:${DB_PORT}..."
if timeout 5 bash -c "echo > /dev/tcp/${DB_HOST}/${DB_PORT}" 2>/dev/null; then
  echo "  -> Port is OPEN"
else
  echo "  -> Port is CLOSED or unreachable"
fi

# =============================================================
# STEP 6: Wait for database to be ready
# =============================================================
echo "Waiting for database connection (up to 60 seconds)..."
DB_READY=false
for i in $(seq 1 30); do
  if php -r "
    try {
      new PDO('mysql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_DATABASE}',
              '${DB_USERNAME}', '${DB_PASSWORD}');
      echo 'ok';
    } catch (Exception \$e) {
      echo 'no';
    }
  " 2>/dev/null | grep -q "ok"; then
    DB_READY=true
    echo "Database is ready!"
    break
  fi
  echo "Attempt ${i}/30: Database not ready, waiting 2s..."
  sleep 2
done

if [ "$DB_READY" != "true" ]; then
  echo "=========================================="
  echo " ERROR: Database did not become ready"
  echo " after 30 attempts (60 seconds)."
  echo ""
  echo " Last PDO error was:"
  php -r "
    try {
      new PDO('mysql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_DATABASE}',
              '${DB_USERNAME}', '${DB_PASSWORD}');
    } catch (Exception \$e) {
      echo \$e->getMessage();
    }
  " 2>&1 || echo "(failed to get PDO error)"
  echo ""
  echo "=========================================="
  exit 1
fi

# =============================================================
# STEP 7: Clear Laravel cache and run migrations
# =============================================================
php artisan config:clear
php artisan cache:clear
php artisan migrate --force
php artisan storage:link

# =============================================================
# STEP 8: Start PHP-FPM
# =============================================================
php-fpm -D

# =============================================================
# STEP 9: Start Nginx on Railway-assigned port
# =============================================================
sed "s/PORT_PLACEHOLDER/${PORT:-8080}/g" /app/nginx.conf > /tmp/nginx.conf
nginx -c /tmp/nginx.conf -g 'daemon off;'
