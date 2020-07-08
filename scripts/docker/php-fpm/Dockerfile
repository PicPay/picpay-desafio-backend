FROM php:7.4-fpm-alpine

RUN apk update && apk --no-cache add postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql

COPY . /var/www/html

RUN chown -Rf www-data:www-data /var/www/html

RUN rm -Rf /var/www/html/var/logs/*.log

USER www-data

RUN cd /var/www/html && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');"

RUN echo "" > /var/www/html/.env

RUN echo "APP_ENV=prod" > /var/www/html/.env && \
    echo "APP_SECRET=1a53ea24793d50a78a34c61102da5ed4" >> /var/www/html/.env && \
    echo "DATABASE_URL=pgsql://postgres:password@picpay-test-postgres:5432/picpay_dev_test?serverVersion=11.0" >> /var/www/html/.env && \
    echo "VENDOR_FOOBAR_API_URL=https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6" >> /var/www/html/.env && \
    echo "VENDOR_BAZQUX_API_URL=https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6" >> /var/www/html/.env && \
    echo "ACCOUNT_BALANCE_ROLLBACK_EXPIRATION_SECONDS=50" >> /var/www/html/.env && \
    echo "CACHE_REDIS_HOST=picpay-test-redis" >> /var/www/html/.env && \
    echo "CACHE_REDIS_PORT=6379" >> /var/www/html/.env

RUN php /var/www/html/composer.phar install
