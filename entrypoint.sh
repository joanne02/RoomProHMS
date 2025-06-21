#!/bin/sh

echo "🔧 Running Laravel setup tasks..."

# Ensure required folders exist
mkdir -p storage/framework/{cache,sessions,views}
mkdir -p bootstrap/cache

# Run Laravel post-deploy commands
php artisan config:cache
php artisan migrate --force
php artisan storage:link || echo "Storage link already exists."

echo "🚀 Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=8080
