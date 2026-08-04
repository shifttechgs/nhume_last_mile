FROM php:8.4-cli-alpine

# System dependencies
# Note: oniguruma-dev and sqlite-dev omitted — mbstring and pdo_sqlite
# are already compiled into php:8.4-cli-alpine
RUN apk add --no-cache \
    curl \
    libzip-dev \
    nodejs \
    npm \
    zip \
    unzip

# Only install extensions NOT already built into the base image.
# pdo_sqlite, mbstring, openssl are compiled in. opcache is compiled in
# but needs enabling. zip and bcmath must be installed.
RUN docker-php-ext-install zip bcmath \
    && docker-php-ext-enable opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy project files
COPY . .

# PHP dependencies
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# JS dependencies and compile assets
RUN npm ci && npm run build

# Storage permissions
RUN chmod -R 775 storage bootstrap/cache \
    && chmod +x docker/start.sh

EXPOSE 10000

CMD ["/var/www/html/docker/start.sh"]
