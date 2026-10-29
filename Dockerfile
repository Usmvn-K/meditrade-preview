FROM dunglas/frankenphp:1-php8.3-alpine

# Install PHP extensions required by Laravel
RUN install-php-extensions \
    pdo_mysql \
    pdo_sqlite \
    bcmath \
    ctype \
    fileinfo \
    mbstring \
    openssl \
    tokenizer \
    xml \
    zip \
    intl \
    gd \
    opcache

WORKDIR /app

# Copy application files
COPY . /app

# Ensure storage and bootstrap directories exist with proper permissions
RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache
# Ensure Composer binary is available
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# If vendor directory does not exist, install composer dependencies
RUN if [ ! -d "vendor" ]; then composer install --no-dev --optimize-autoloader --no-progress; fi

# Copy FrankenPHP Caddyfile
COPY Caddyfile /etc/caddy/Caddyfile
COPY Caddyfile /app/Caddyfile

ENV PORT=80 \
    APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
