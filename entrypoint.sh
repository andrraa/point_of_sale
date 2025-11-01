#!/bin/sh

cd /var/www/denai-murah

chown -R www-data:www-data /var/www/denai-murah
chmod -R 775 storage bootstrap/cache

if ! grep -q "APP_KEY=" .env || grep -q "APP_KEY=$" .env; then
    echo ">> Generating new APP_KEY..."
    php artisan key:generate --force
fi

php artisan optimize:clear
php artisan config:cache

echo ">> Starting PHP-FPM..."
exec php-fpm
