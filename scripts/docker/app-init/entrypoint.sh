#!/bin/sh

php /var/www/html/bin/console doctrine:database:create
php /var/www/html/bin/console doctrine:migrations:migrate -q
