FROM php:7.4-fpm-alpine

RUN apk --update add --no-cache \
    nginx \
    supervisor \
    curl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

COPY ./docker/bin/*   /bin/
COPY ./docker/etc/*   /etc/
COPY ./docker/etc/nginx/conf.d/api.conf /etc/nginx/conf.d/default.conf
COPY ./api /api

WORKDIR /api

RUN composer install --no-interaction --optimize-autoloader \
    && touch /api/database/database.sqlite \
    && mkfifo -m 600 ./storage/logs/lumen.log \
    && chown www-data:www-data -R .

EXPOSE 80

ENTRYPOINT ["sh", "-c", "/bin/start-app.sh" ]
