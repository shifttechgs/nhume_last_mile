FROM php:8.4-cli-alpine

# System dependencies
RUN apk add --no-cache \
    curl \
    libzip-dev \
    nodejs \
    npm \
    zip \
    unzip

# Only install extensions NOT already compiled into php:8.4-cli-alpine
RUN docker-php-ext-install zip bcmath \
    && docker-php-ext-enable opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy project files
COPY . .

# PHP dependencies — no-scripts avoids running php artisan during build
# (no .env or DB available at build time)
RUN composer install \
    --no-dev \
    --no-scripts \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# Build frontend assets
RUN npm ci && npm run build

# Storage permissions
RUN chmod -R 775 storage bootstrap/cache \
    && chmod +x docker/start.sh

EXPOSE 10000

CMD ["/var/www/html/docker/start.sh"]
