FROM php:8.4-cli-alpine

# System dependencies
RUN apk add --no-cache \
    curl \
    libzip-dev \
    nodejs \
    npm \
    zip \
    unzip

# PHP extensions (only those NOT already compiled into php:8.4-cli-alpine)
RUN docker-php-ext-install zip bcmath \
    && docker-php-ext-enable opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy project (excludes .env, vendor, node_modules — see .dockerignore)
COPY . .

# Set permissions before running artisan
RUN chmod -R 775 storage bootstrap/cache \
    && chmod +x docker/start.sh

# Create a build-time .env so composer post-install scripts (package:discover)
# can run. start.sh overwrites this with the real production config at runtime.
RUN touch database/database.sqlite \
    && cp .env.example .env \
    && sed -i 's|^DB_CONNECTION=.*|DB_CONNECTION=sqlite|' .env \
    && sed -i 's|^SESSION_DRIVER=.*|SESSION_DRIVER=file|' .env \
    && sed -i 's|^CACHE_STORE=.*|CACHE_STORE=file|' .env \
    && sed -i 's|^QUEUE_CONNECTION=.*|QUEUE_CONNECTION=sync|' .env \
    && php artisan key:generate

# PHP dependencies (scripts enabled — package:discover runs here)
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# Build frontend assets
RUN npm ci && npm run build

EXPOSE 10000

CMD ["/var/www/html/docker/start.sh"]
