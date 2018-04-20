FROM php:7.2-fpm-alpine3.7

WORKDIR /var/www/

COPY composer.json /var/www/

COPY phpunit.xml.dist /var/www/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN docker-php-ext-install pdo pdo_mysql

RUN composer install --no-dev --no-interaction