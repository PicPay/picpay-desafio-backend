FROM picpay/php:7.2-fpm-base

COPY ./                             /app
COPY ./support/docker/config/       /

RUN pecl install -f mongodb-1.5.3

RUN composer install \
    && composer dump-autoload -a \
    # && php artisan optimize \
    && chown -R www-data:www-data /var/tmp/nginx \
    && chown -R www-data:www-data /app/storage \
    && chmod +x /start.sh

# entrypoint
ENTRYPOINT ["sh", "-c"]

EXPOSE 80

# start
CMD ["/start.sh"]
