# Stage 1: Use Composer image to install dependencies
FROM composer:2 AS composer

WORKDIR /app

# Copy only composer files to leverage Docker cache
COPY composer.json composer.lock ./

# Install dependencies (production only)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Stage 2: PHP + Apache
FROM php:8.2-apache

# Enable Apache rewrite
RUN a2enmod rewrite

# Install PHP extensions required by Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql zip

# Set Apache document root to Laravel public folder
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy application files
COPY . /var/www/html

# Copy vendor folder from composer stage
COPY --from=composer /app/vendor /var/www/html/vendor

# Make sure storage and cache directories exist and have proper permissions
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
