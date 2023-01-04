#!/bin/sh
set -e

echo "Deploying application ..."

# Enter maintenance mode
(php artisan down) || true
    # Update codebase
    git fetch origin deploy
    git reset --hard origin/deploy

    # Install dependencies based on lock file
    # composer update --no-interaction --prefer-dist --optimize-autoloader
    composer install --no-interaction --prefer-dist --optimize-autoloader

    # Migrate database
    php artisan migrate --force

    # Clear cache
    php artisan optimize:clear
    # Clear Shopper Symlink
    cd ./public
    rm shopper
    cd ../
    php artisan shopper:link
    php artisan storage:link --force
    # Clear cache again
    php artisan optimize:clear
    php artisan optimize

    # Note: If you're using queue workers, this is the place to restart them.
    php artisan queue:restart

    # Reload PHP to update opcache
    # echo "" | sudo -S service php8.1-fpm reload
# Exit maintenance mode
php artisan up

echo "Application deployed!"
