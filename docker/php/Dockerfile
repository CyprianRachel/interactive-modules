FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql

# Instalacja Composera
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Instalacja zależności
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install zip

WORKDIR /var/www/html
