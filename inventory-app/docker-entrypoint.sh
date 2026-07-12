#!/bin/sh
set -e

# Update Apache port dynamically if $PORT is provided by Railway
if [ -n "$PORT" ]; then
    echo "Setting Apache to listen on port $PORT..."
    sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf
    sed -i "s/<VirtualHost \*:80>/<VirtualHost *:$PORT>/g" /etc/apache2/sites-available/*.conf
fi

# Disable conflicting Apache MPM modules at runtime to avoid AH00534
a2dismod mpm_event mpm_worker 2>/dev/null || true

echo "Database Configuration Info:"
echo "  DB_HOST: '${DB_HOST}'"
echo "  DB_PORT: '${DB_PORT}'"
echo "  DB_DATABASE: '${DB_DATABASE}'"
echo "  DB_USERNAME: '${DB_USERNAME}'"

echo "Waiting for database connection to be ready..."
until php -r "try { new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); exit(0); } catch (Exception \$e) { fwrite(STDERR, \$e->getMessage() . PHP_EOL); exit(1); }"; do
    echo "Database is unavailable - sleeping..."
    sleep 2
done

echo "Database connection established."

echo "Running database migrations..."
php artisan migrate --force

# echo "Running database seeders..."
# php artisan db:seed --force

echo "Creating storage symlink..."
php artisan storage:link --force

echo "Optimizing application caches..."
php artisan optimize

# Execute the container's main command (e.g. apache2-foreground)
exec "$@"
