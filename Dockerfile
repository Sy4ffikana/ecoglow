FROM composer:2.6 as vendor

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

COPY . .

RUN composer install --optimize-autoloader --no-dev

FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=vendor /app /var/www/html/

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html \
 && a2enmod rewrite
