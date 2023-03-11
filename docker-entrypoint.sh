#!/bin/bash
env >> /etc/environment
cd /var/www/html && composer install
exec apache2-foreground
touch /var/www/html/logs/error.log
tail -f /var/www/html/logs/error.log