#!/bin/bash
set -e

# Configure port from Render
PORT_NUM=${PORT:-80}
sed -i "s/Listen 80/Listen ${PORT_NUM}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT_NUM}>/g" /etc/apache2/sites-available/000-default.conf

# Setup SQLite database in env
sed -i 's/DB_CONNECTION=.*/DB_CONNECTION=sqlite/g' /var/www/html/.env
sed -i '/DB_HOST/d' /var/www/html/.env
sed -i '/DB_PORT/d' /var/www/html/.env
sed -i '/DB_DATABASE/d' /var/www/html/.env
sed -i '/DB_USERNAME/d' /var/www/html/.env
sed -i '/DB_PASSWORD/d' /var/www/html/.env

# Generate application key
php artisan key:generate --force

# Create SQLite database file
touch /var/www/html/database/database.sqlite
chown -R www-data:www-data /var/www/html/database
chmod -R 775 /var/www/html/database

# Run migrations
php artisan migrate --force

# Seed default admin user
php artisan tinker --execute="App\Models\User::firstOrCreate(['email' => 'admin@admin.com'], ['name' => 'Administrador', 'password' => Hash::make('admin123')]);"

# Start Apache in foreground
exec apache2-foreground
