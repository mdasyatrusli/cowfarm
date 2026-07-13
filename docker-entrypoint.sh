#!/bin/sh
set -e

echo "==> Generating app key (if missing)"
php artisan key:generate --force || true

echo "==> Running migrations"
php artisan migrate --force

echo "==> Running seeders (super admin + demo data)"
php artisan db:seed --force

echo "==> Caching config for production"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Starting PHP built-in server on 0.0.0.0:${PORT:-8080}"
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}