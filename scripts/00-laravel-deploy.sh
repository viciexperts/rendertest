#!/usr/bin/env bash
set -e

echo "Installing composer dependencies..."
composer install --no-dev --working-dir=/var/www/html --optimize-autoloader

echo "Preparing SQLite database..."
mkdir -p /var/data
touch "${DB_DATABASE:-/var/data/database.sqlite}"

if [ -z "${APP_KEY:-}" ]; then
    if [ ! -s /var/data/app.key ]; then
        echo "Generating persistent Laravel APP_KEY..."
        php artisan key:generate --show > /var/data/app.key
    fi

    export APP_KEY="$(cat /var/data/app.key)"
fi

cat > /var/www/html/.env <<EOF
APP_NAME="${APP_NAME:-Render Test}"
APP_ENV="${APP_ENV:-production}"
APP_KEY="${APP_KEY}"
APP_DEBUG="${APP_DEBUG:-false}"
APP_URL="${APP_URL:-https://rendertest-428u.onrender.com}"
DB_CONNECTION="${DB_CONNECTION:-sqlite}"
DB_DATABASE="${DB_DATABASE:-/var/data/database.sqlite}"
LOG_CHANNEL="${LOG_CHANNEL:-stderr}"
SESSION_DRIVER="${SESSION_DRIVER:-database}"
CACHE_STORE="${CACHE_STORE:-database}"
QUEUE_CONNECTION="${QUEUE_CONNECTION:-database}"
EOF

echo "Caching Laravel config..."
php artisan config:clear
php artisan config:cache

echo "Caching routes..."
php artisan route:clear
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force
