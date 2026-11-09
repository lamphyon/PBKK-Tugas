#!/bin/bash
set -e

echo "Starting deployment..."

# Pull latest changes from git
git pull origin main

# Install PHP dependencies (skipping dev dependencies)
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Install Node dependencies and build Vite assets for Vue
npm ci
php artisan adminlte:install --only=assets --only=vendor_assets --force --no-interaction
npm run build

# Run database migrations
php artisan migrate --force
php artisan db:seed --class=RolePermissionSeeder --force

# Clear and cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Deployment finished successfully!"
