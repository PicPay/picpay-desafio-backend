#!/bin/sh

# log
mkdir -p /app/storage/logs
rm -f /app/storage/logs/app.log
touch /app/storage/logs/app.log

# cache
chown -R www-data:www-data /app/storage/

# supervisor
exec supervisord -c /etc/supervisord.conf
