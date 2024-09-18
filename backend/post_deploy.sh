#!/bin/sh
set -e

role=${CONTAINER_ROLE:-app}

if [ $role = "app" ]; then

    echo "Running migration and seeds..."
    php artisan migrate --seed
    while [ $? -ne 0 ]; do
        sleep 10
        php artisan migrate --seed --force
    done

    echo "Optimizing application..."
    php artisan config:clear
    php artisan cache:clear
    php artisan storage:link

    php-fpm -D && nginx -g "daemon off;"
    while [ true ]; do
        php artisan schedule:run
        sleep 60
    done
else
    echo "Could not match the container role \"$role\""
    exit 1
fi
