#!/bin/bash
set -e

export MYSQL_URL="${MYSQL_URL:-$DATABASE_URL}"

if [ -n "$MYSQL_URL" ]; then
  export DATABASE_URL="$MYSQL_URL"

  DB_USERNAME=$(echo "$MYSQL_URL" | sed -n 's|mysql://\([^:]*\):.*|\1|p')
  DB_PASSWORD=$(echo "$MYSQL_URL" | sed -n 's|mysql://[^:]*:\([^@]*\)@.*|\1|p')
  DB_HOST=$(echo "$MYSQL_URL" | sed -n 's|mysql://[^@]*@\([^:/]*\).*|\1|p')
  DB_PORT=$(echo "$MYSQL_URL" | sed -n 's|mysql://[^@]*@[^:/]*:\([^/]*\)/.*|\1|p')
  DB_DATABASE=$(echo "$MYSQL_URL" | sed -n 's|.*/\([^?]*\)|\1|p')

  [ -n "$DB_USERNAME" ] && export DB_USERNAME
  [ -n "$DB_PASSWORD" ] && export DB_PASSWORD
  [ -n "$DB_HOST" ] && export DB_HOST
  [ -n "$DB_PORT" ] && export DB_PORT
  [ -n "$DB_DATABASE" ] && export DB_DATABASE
  export DB_CONNECTION=mysql
fi

echo "Waiting for database connection..."
for i in $(seq 1 30); do
  php -r "
    try {
      new PDO('mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_DATABASE', '$DB_USERNAME', '$DB_PASSWORD');
      echo 'ok';
    } catch (Exception \$e) {
      echo 'no';
    }
  " 2>/dev/null | grep -q "ok" && break
  echo "Attempt $i: DB not ready, waiting 2s..."
  sleep 2
done

php artisan migrate --force
php artisan storage:link

php-fpm -D

sed "s/PORT_PLACEHOLDER/${PORT:-8080}/g" /app/nginx.conf > /tmp/nginx.conf
nginx -c /tmp/nginx.conf -g 'daemon off;'
