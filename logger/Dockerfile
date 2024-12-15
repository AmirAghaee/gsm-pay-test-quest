FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install sockets zip pdo_mysql gd

RUN apt-get install -y iputils-ping

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer global require laravel/installer
ENV PATH="${PATH}:/root/.composer/vendor/bin"

WORKDIR /var/www/html

COPY ./authenticate/ /var/www/html/

RUN composer install --no-scripts --no-autoloader
RUN composer dump-autoload

RUN chown -R www-data:www-data /var/www/html/storage

EXPOSE 9000

CMD ["php-fpm"]

