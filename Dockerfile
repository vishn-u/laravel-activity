# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip curl && \
    docker-php-ext-install pdo_mysql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for caching
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy Laravel project files
COPY . /var/www/html

# Set Laravel storage/cache permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copy Apache virtual host config
COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf

# Expose Apache port
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
