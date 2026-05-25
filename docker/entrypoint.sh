#!/bin/sh
set -e

cd /var/www/html

# Create SQLite database file if it does not exist
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
    chown www-data:www-data database/database.sqlite
fi

# Run database migrations
php artisan migrate --force

# Create public storage symlink
php artisan storage:link --force 2>/dev/null || true

# Cache configuration, routes and views for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Hand off to supervisord (nginx + php-fpm)
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
