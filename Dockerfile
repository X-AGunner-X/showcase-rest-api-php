FROM php:8.3-apache

COPY --from=composer:2.2.7 /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
    apt-get install -y \
    curl unzip \
    && apt-get clean

WORKDIR /var/www/html

COPY . /var/www/html
