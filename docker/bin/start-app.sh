#!/bin/sh

# opcache
if [ "${OPCACHE_DISABLED}" != true ]; then
    docker-php-ext-enable opcache;
fi

FILE=/api/.env
if [[ ! -f "$FILE" ]]; then
    cp .env.example .env
    chown www-data:www-data .env
fi

php artisan migrate
php artisan db:seed --class=UserSeeder

# supervisor
exec supervisord -c /etc/supervisord.conf
