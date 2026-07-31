FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

COPY docker/apache/server-name.conf /etc/apache2/conf-available/server-name.conf
RUN a2enconf server-name

COPY app/ /var/www/html/

WORKDIR /var/www/html

EXPOSE 80