#!/bin/bash
set -e

# Configure port from Render
PORT_NUM=${PORT:-80}
sed -i "s/Listen 80/Listen ${PORT_NUM}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT_NUM}>/g" /etc/apache2/sites-available/000-default.conf

# Setup environment
sed -i 's/DB_CONNECTION=.*/DB_CONNECTION=sqlite/g' /var/www/html/.env
sed -i '/DB_HOST/d' /var/www/html/.env
sed -i '/DB_PORT/d' /var/www/html/.env
sed -i '/DB_DATABASE/d' /var/www/html/.env
sed -i '/DB_USERNAME/d' /var/www/html/.env
sed -i '/DB_PASSWORD/d' /var/www/html/.env
sed -i 's/SESSION_DRIVER=.*/SESSION_DRIVER=file/g' /var/www/html/.env
sed -i 's/CACHE_STORE=.*/CACHE_STORE=file/g' /var/www/html/.env
sed -i 's/QUEUE_CONNECTION=.*/QUEUE_CONNECTION=sync/g' /var/www/html/.env
sed -i 's/APP_ENV=.*/APP_ENV=production/g' /var/www/html/.env
sed -i 's/APP_DEBUG=.*/APP_DEBUG=false/g' /var/www/html/.env

# Generate application key
php artisan key:generate --force

# Create SQLite database file
touch /var/www/html/database/database.sqlite
chown -R www-data:www-data /var/www/html/database
chmod -R 775 /var/www/html/database

# Run migrations and seeders
php artisan migrate --force
php artisan db:seed --force

# Cache config for performance
php artisan config:cache
php artisan route:cache

# Fix permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Start Apache in foreground
exec apache2-foreground
