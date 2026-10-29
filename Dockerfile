FROM php:8.2-cli-alpine

# Set working directory
WORKDIR /var/www/html

# Install system dependencies and required PHP extensions
# Note: openssl, tokenizer, json, and ctype are core built-in extensions in PHP 8.2+
RUN apk add --no-cache \
    git \
    curl \
    zip \
    unzip \
    sqlite-dev \
    libxml2-dev \
    oniguruma-dev \
    libzip-dev \
    linux-headers \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_sqlite \
    mbstring \
    xml \
    bcmath \
    ctype \
    zip

# Copy Composer binary from official composer:2 image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application source code
COPY . .

# Create SQLite database file and set permissions
RUN touch database/database.sqlite && chmod 777 database/database.sqlite

# Ensure storage, bootstrap, and database directories exist with proper write permissions
RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache database

# Install production PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Ensure storage, bootstrap/cache, and database permissions
RUN chmod -R 777 storage bootstrap/cache database

# Expose default port
EXPOSE 10000

# Startup command to run migrations and start the built-in PHP web server
CMD sh -c 'php artisan migrate --force && php -S 0.0.0.0:${PORT:-10000} -t public'
