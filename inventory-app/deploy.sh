#!/bin/bash
set -e

echo "=== Starting Deployment for InLife Telkomsel ==="

# 1. Pull the latest code from Git
echo "Pulling latest changes from Git..."
git pull origin main

# 2. Build and restart Docker containers in detached mode
echo "Rebuilding and restarting Docker containers..."
docker compose up -d --build

# 3. Run Laravel migrations inside the web container
echo "Running Laravel database migrations..."
docker compose exec -T web php artisan migrate --force

# 5. Clear and optimize caches
echo "Optimizing application caches..."
docker compose exec -T web php artisan optimize
docker compose exec -T web php artisan view:clear

echo "=== Deployment Completed Successfully! ==="
echo "Application is now running on http://localhost:8080"
