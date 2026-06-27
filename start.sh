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

# Parse URL using PHP's parse_url() — far more reliable than sed
DB_PARSE=$(php -r '
  $u = parse_url($argv[1]);
  echo ($u["user"] ?? "") . "\n";
  echo ($u["pass"] ?? "") . "\n";
  echo ($u["host"] ?? "") . "\n";
  echo ($u["port"] ?? "3306") . "\n";
  echo ltrim($u["path"] ?? "", "/") . "\n";
' "$DB_URL")

DB_USERNAME=$(echo "$DB_PARSE" | sed -n '1p')
DB_PASSWORD=$(echo "$DB_PARSE" | sed -n '2p')
DB_HOST=$(echo "$DB_PARSE"     | sed -n '3p')
DB_PORT=$(echo "$DB_PARSE"     | sed -n '4p')
DB_DATABASE=$(echo "$DB_PARSE" | sed -n '5p')

# Fallback if database name missing from URL
if [ -z "$DB_DATABASE" ]; then
  DB_DATABASE="${MYSQL_DATABASE:-railway}"
fi

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
# STEP 3: Log database config (safe, no password)
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
# STEP 8: Generate PHP-FPM config and start it
# =============================================================
cat > /tmp/php-fpm.conf << 'PHPFPMCONF'
[global]
pid = /var/run/php-fpm.pid
error_log = /var/log/php-fpm.log
log_level = notice
daemonize = yes

[www]
listen = 127.0.0.1:9000
listen.allowed_clients = 127.0.0.1
user = nobody
group = nogroup
pm = dynamic
pm.max_children = 10
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 5
php_admin_value[error_log] = /var/log/php-fpm-www.log
PHPFPMCONF

php-fpm -y /tmp/php-fpm.conf

# =============================================================
# STEP 9: Generate nginx.conf and start Nginx
# =============================================================
NGINX_PORT="${PORT:-8080}"
cat > /tmp/nginx.conf << NGINXCONF
worker_processes  auto;
error_log  /var/log/nginx/error.log warn;
pid        /var/run/nginx.pid;
events {
    worker_connections  1024;
}
http {
    types {
        text/html                             html htm shtml;
        text/css                              css;
        text/xml                              xml;
        image/gif                             gif;
        image/jpeg                            jpeg jpg;
        application/javascript                js;
        application/json                      json;
        application/pdf                       pdf;
        application/zip                       zip;
        image/png                             png;
        image/svg+xml                         svg svgz;
        image/x-icon                          ico;
        image/webp                            webp;
        font/woff                             woff;
        font/woff2                            woff2;
        application/x-font-ttf                ttf ttc;
        application/x-font-otf                otf;
        application/xhtml+xml                 xhtml;
        audio/mpeg                            mp3;
        audio/ogg                             ogg;
        video/mp4                             mp4;
        video/webm                            webm;
        text/plain                            txt;
    }
    default_type  application/octet-stream;
    access_log  /var/log/nginx/access.log;
    sendfile        on;
    keepalive_timeout  65;
    server {
        listen  ${NGINX_PORT};
        index index.php index.html;
        server_name  _;
        root  /app/public;
        location / {
            try_files \$uri \$uri/ /index.php\$is_args\$args;
        }
        location ~ \.php\$ {
            fastcgi_pass  127.0.0.1:9000;
            fastcgi_index index.php;
            fastcgi_param  SCRIPT_FILENAME    /app/public\$fastcgi_script_name;
            fastcgi_param  QUERY_STRING       \$query_string;
            fastcgi_param  REQUEST_METHOD     \$request_method;
            fastcgi_param  CONTENT_TYPE       \$content_type;
            fastcgi_param  CONTENT_LENGTH     \$content_length;
            fastcgi_param  SCRIPT_NAME        \$fastcgi_script_name;
            fastcgi_param  REQUEST_URI        \$request_uri;
            fastcgi_param  DOCUMENT_URI       \$document_uri;
            fastcgi_param  DOCUMENT_ROOT      \$document_root;
            fastcgi_param  SERVER_PROTOCOL    \$server_protocol;
            fastcgi_param  REQUEST_SCHEME     \$scheme;
            fastcgi_param  GATEWAY_INTERFACE  CGI/1.1;
            fastcgi_param  SERVER_SOFTWARE    nginx;
            fastcgi_param  REMOTE_ADDR        \$remote_addr;
            fastcgi_param  REMOTE_PORT        \$remote_port;
            fastcgi_param  SERVER_ADDR        \$server_addr;
            fastcgi_param  SERVER_PORT        \$server_port;
            fastcgi_param  SERVER_NAME        \$server_name;
        }
        location ~ /\.(?!well-known).* {
            deny all;
        }
    }
}
NGINXCONF

nginx -c /tmp/nginx.conf -g 'daemon off;'
