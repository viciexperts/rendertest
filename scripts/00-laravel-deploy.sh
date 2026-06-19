#!/usr/bin/env bash
set -e

echo "Installing composer dependencies..."
composer install --no-dev --working-dir=/var/www/html --optimize-autoloader

echo "Preparing SQLite database..."
mkdir -p /var/data
touch "${DB_DATABASE:-/var/data/database.sqlite}"

echo "Caching Laravel config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force
