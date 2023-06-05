#!/bin/bash

# Update nginx to match worker_processes to no. of cpu's
procs=$(cat /proc/cpuinfo | grep processor | wc -l)
sed -i -e "s/worker_processes  1/worker_processes $procs/" /etc/nginx/nginx.conf

# Always chown webroot for better mounting
php artisan storage:link
# php artisan config:cache
# php artisan route:cache
# php artisan view:cache

chown -Rf nginx:nginx /usr/share/nginx/html

chown -Rf nginx:nginx /usr/share/nginx/html/storage

# Start supervisord and services
/usr/local/bin/supervisord -n -c /etc/supervisord.conf
