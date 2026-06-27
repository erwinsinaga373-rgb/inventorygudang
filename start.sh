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

php artisan migrate --force
php artisan storage:link

php-fpm -D

sed "s/PORT_PLACEHOLDER/${PORT:-8080}/g" /app/nginx.conf > /tmp/nginx.conf
nginx -c /tmp/nginx.conf -g 'daemon off;'
