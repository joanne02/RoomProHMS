#!/bin/sh

echo "🔧 Running Laravel setup tasks..."

# Ensure required folders exist
mkdir -p storage/framework/{cache,sessions,views}
mkdir -p bootstrap/cache

# Set correct permissions (important for storage link access)
chmod -R 775 storage bootstrap/cache

# Ensure environment is cached
php artisan config:cache

# Run database migrations
php artisan migrate --force

# Wait a moment to ensure Laravel is fully initialized (optional safety)
sleep 3

# Create symbolic link (if it doesn't exist)
if [ ! -L "public/storage" ]; then
  php artisan storage:link
else
  echo "Storage link already exists."
fi

echo "🚀 Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=8080
