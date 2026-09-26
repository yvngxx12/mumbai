FROM composer:2 AS composer

FROM php:8.3-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
        libonig-dev \
        libpq-dev \
        libzip-dev \
        unzip \
    && docker-php-ext-install mbstring opcache pdo_pgsql zip \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && a2enmod rewrite headers

COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2dissite 000-default && a2ensite 000-default

COPY . /var/www/html

COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader \
    && php artisan storage:link

EXPOSE 80

CMD ["bash", "-c", "php artisan migrate --force --no-interaction && php artisan db:seed --force --no-interaction && apache2-foreground"]