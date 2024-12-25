# Use official PHP FPM image
FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . /var/www/html

# Install dependencies (if composer.json is in the project root)
RUN composer install --no-scripts --no-autoloader

# Generate optimized autoload files
RUN composer dump-autoload -o

# Copy the entrypoint script if you have one (optional)
# COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
# RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 9000

CMD ["php-fpm"]
