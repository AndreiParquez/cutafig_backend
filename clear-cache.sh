#!/bin/bash

echo "🚀 Deploying to Railway and clearing cache..."

# Clear all Laravel caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Run migrations to ensure cache table exists
php artisan migrate --force

echo "✅ Cache cleared and migrations completed!"
