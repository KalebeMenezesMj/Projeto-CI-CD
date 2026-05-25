# Stage 1 — install PHP dependencies without dev packages
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN COMPOSER_MEMORY_LIMIT=-1 composer install \
    --optimize-autoloader \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --no-scripts \
    --ignore-platform-reqs

# Stage 2 — production image
FROM php:8.2-fpm-alpine AS production

# Install system packages and PHP extensions
RUN apk add --no-cache \
        nginx \
        supervisor \
        sqlite \
        libpng \
        libjpeg-turbo \
        freetype \
        libzip \
        icu-libs \
    && apk add --no-cache --virtual .build-deps \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        libzip-dev \
        icu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_sqlite \
        pdo_mysql \
        gd \
        zip \
        bcmath \
        opcache \
        intl \
        exif \
        pcntl \
    && apk del .build-deps \
    && rm -rf /var/cache/apk/*

WORKDIR /var/www/html

# Copy vendor from Stage 1
COPY --from=vendor /app/vendor ./vendor

# Copy application source (excluding files in .dockerignore)
COPY . .

# Create required runtime directories and set permissions
RUN mkdir -p \
        storage/framework/sessions \
        storage/framework/views \
        storage/framework/cache/data \
        storage/logs \
        storage/app/public \
        bootstrap/cache \
        database \
    && chown -R www-data:www-data storage bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache database

# Copy Docker config files
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/app.ini
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
