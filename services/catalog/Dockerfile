# services/*/Dockerfile
FROM php:8.2-fpm

# system deps
RUN apt-get update && apt-get install -y \
    git zip unzip libzip-dev libonig-dev libpng-dev libxml2-dev libcurl4-openssl-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath

# install composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# copy app
COPY src/ /var/www/html

# install deps
RUN composer install --no-dev --optimize-autoloader --no-interaction

# storage permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
