FROM php:7.4-apache-buster

# Installing minimum system packages
RUN apt-get update && apt-get install -y \
    libicu-dev \
    unzip

# Installing minimum PHP extensions
RUN docker-php-ext-install \
    intl \
    mysqli \
    pdo \
    pdo_mysql

# Apache Configurations
ENV APACHE_DOCUMENT_ROOT /var/www/html/webroot
RUN a2enmod rewrite

# Installing composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN chmod +x /var/www/html/docker-entrypoint.sh

ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]