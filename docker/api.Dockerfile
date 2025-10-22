FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    postgresql-dev \
    zip \
    unzip \
    git \
    curl

RUN docker-php-ext-install pdo pdo_pgsql pcntl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY apps/api/composer*.json ./
RUN composer install --no-scripts --no-autoloader

COPY apps/api .
RUN composer dump-autoload --optimize

RUN chmod +x artisan

EXPOSE 8000

CMD php artisan octane:start --server=roadrunner --host=0.0.0.0 --port=8000
