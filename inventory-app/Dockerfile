# Stage 1: Build assets using Node
FROM node:18-alpine AS assets-builder
WORKDIR /app
COPY package*.json vite.config.js tailwind.config.js ./
RUN npm install
COPY resources/ ./resources/
COPY public/ ./public/
RUN npm run build

# Stage 2: Build Laravel application using PHP 8.2 Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libjpeg-dev \
    libfreetype6-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Enable Apache rewrite module
RUN a2enmod rewrite

# Change Apache document root to Laravel public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Set working directory
# Set working directory
WORKDIR /var/www/html

# Copy composer dependency definitions first
COPY composer.json composer.lock ./

# Install Composer dependencies (without dev, scripts, or autoloader)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --no-autoloader

# Copy application files
COPY . .

# Copy compiled assets from Stage 1
COPY --from=assets-builder /app/public/build ./public/build

# Dump optimized autoloader
RUN composer dump-autoload --optimize --no-dev

# Set permissions for Laravel storage and cache directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]

# Expose port 80
EXPOSE 80

# Command to start Apache
CMD ["apache2-foreground"]
