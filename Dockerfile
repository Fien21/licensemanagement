FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libonig-dev \
    libzip-dev \
    libxml2-dev \
    zlib1g-dev \
    libpng-dev \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        bcmath \
        zip \
        gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files first (cache-friendly)
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN php -d memory_limit=-1 /usr/bin/composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# Copy application files
COPY . .

# Set Laravel permissions
RUN chown -R www-data:www-data \
    /var/www/storage \
    /var/www/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
