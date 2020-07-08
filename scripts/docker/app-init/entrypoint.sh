#!/bin/sh

php /var/www/html/bin/console doctrine:database:create
php /var/www/html/bin/console doctrine:migrations:migrate -q
php /var/www/html/bin/console doctrine:fixtures:load -q

php /var/www/html/composer.phar run coverage

cp /var/www/html/tests/_reports/unit/coverage /var/www/html/public/coverage -Rf
