# syntax=docker/dockerfile:1

# Laravel 12 + PostgreSQL (Render-compatible)
# PHP 8.3 CLI + FPM, pdo_pgsql, composer, node/npm for asset build

FROM php:8.3-fpm-alpine

# --- System deps ---
RUN apk add --no-cache \
    git \
    unzip \
    curl \
    libpq-dev \
    oniguruma-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    nodejs \
    npm

# --- PHP extensions ---
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip pcntl gd

# --- Composer ---
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# --- Composer deps (leverage layer cache) ---
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# --- App source ---
COPY . .

# --- Build frontend assets (Vite) inside the image ---
RUN npm install && npm run build

# --- Permissions ---
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# --- Entrypoint: migrate + seed + serve ---
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]