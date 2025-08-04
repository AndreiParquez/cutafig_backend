#!/bin/bash

# Railway Start Script for Laravel
# This script ensures proper port handling for Railway deployment

echo "=== Railway Laravel Start Script ==="
echo "PORT environment variable: $PORT"
echo "Current working directory: $(pwd)"

# Set default port if PORT is not set
if [ -z "$PORT" ]; then
    echo "Warning: PORT environment variable not set, defaulting to 8000"
    export PORT=8000
fi

echo "Starting Laravel on port: $PORT"

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

# Clear configuration cache
echo "Clearing configuration cache..."
php artisan config:clear

# Start the Laravel server
echo "Starting Laravel server..."
exec php artisan serve --host=0.0.0.0 --port=$PORT
