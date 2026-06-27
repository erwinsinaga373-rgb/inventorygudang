#!/bin/bash
set -e

export DATABASE_URL="${DATABASE_URL:-$MYSQL_URL}"

php artisan migrate --force
php artisan storage:link

php-fpm -D

sed "s/PORT_PLACEHOLDER/${PORT:-8080}/g" /app/nginx.conf > /tmp/nginx.conf
nginx -c /tmp/nginx.conf -g 'daemon off;'
