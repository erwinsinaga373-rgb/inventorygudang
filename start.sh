#!/bin/bash
set -e

# =============================================================
# STEP 1: Parse database URL from Railway environment variables
# =============================================================
# Railway MySQL plugin auto-generates MYSQL_URL (internal) and
# MYSQL_PUBLIC_URL (external). Laravel natively reads DATABASE_URL.
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

# Parse URL components using sed
# Format: mysql://user:password@host:port/database
DB_USERNAME=$(echo "$DB_URL" | sed -n 's|mysql://\([^:]*\):.*|\1|p')
DB_PASSWORD=$(echo "$DB_URL" | sed -n 's|mysql://[^:]*:\([^@]*\)@.*|\1|p')
DB_HOST=$(echo "$DB_URL"     | sed -n 's|mysql://[^@]*@\([^:/]*\).*|\1|p')
DB_PORT=$(echo "$DB_URL"     | sed -n 's|mysql://[^@]*@[^:/]*:\([^/]*\)/.*|\1|p')
DB_DATABASE=$(echo "$DB_URL" | sed -n 's|.*/\([^?]*\)|\1|p')

# If port wasn't parsed (no port in URL), default to 3306
[ -z "$DB_PORT" ] && DB_PORT="3306"

# Export so Laravel picks them up
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
# STEP 3: Log database config (safe, without password)
# =============================================================
echo "=========================================="
echo " Database configuration:"
echo "   DB_HOST:      ${DB_HOST}"
echo "   DB_PORT:      ${DB_PORT}"
echo "   DB_DATABASE:  ${DB_DATABASE}"
echo "   DB_USERNAME:  ${DB_USERNAME}"
echo "=========================================="

# =============================================================
# STEP 4: Wait for database to be ready
# =============================================================
echo "Waiting for database connection..."
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
  echo " after 30 attempts."
  echo ""
  echo " Check:"
  echo "   1. MySQL service is running in Railway"
  echo "   2. App and MySQL are in the same project"
  echo "   3. Host '${DB_HOST}' is reachable on port ${DB_PORT}"
  echo "=========================================="
  exit 1
fi

# =============================================================
# STEP 5: Clear Laravel cache and run migrations
# =============================================================
php artisan config:clear
php artisan cache:clear
php artisan migrate --force
php artisan storage:link

# =============================================================
# STEP 6: Start PHP-FPM
# =============================================================
php-fpm -D

# =============================================================
# STEP 7: Start Nginx on Railway-assigned port
# =============================================================
sed "s/PORT_PLACEHOLDER/${PORT:-8080}/g" /app/nginx.conf > /tmp/nginx.conf
nginx -c /tmp/nginx.conf -g 'daemon off;'
