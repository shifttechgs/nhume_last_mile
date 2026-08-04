FROM php:8.4-cli-alpine

# System dependencies
RUN apk add --no-cache \
    curl \
    libzip-dev \
    oniguruma-dev \
    sqlite-dev \
    nodejs \
    npm \
    zip \
    unzip

# PHP extensions required by Laravel
RUN docker-php-ext-install \
    pdo_sqlite \
    zip \
    mbstring \
    bcmath \
    opcache

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
