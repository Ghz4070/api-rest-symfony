FROM php:8.0.1-fpm-alpine3.13

RUN docker-php-ext-install pdo_mysql

WORKDIR /var/www/html

#RUN apt-get update && \
#    apt-get install -y nano vim tree git libzip-dev zip gnupg && \
#    docker-php-ext-configure zip && \
#    docker-php-ext-install zip && \
#    docker-php-ext-install pdo_mysql && \
#    docker-php-ext-install mysqli && \
#    docker-php-ext-install bcmath && \
#    pecl install xdebug && \
#    docker-php-ext-enable xdebug
#
#RUN apt-get install -y libpng-dev libfreetype6-dev libjpeg62-turbo-dev && \
#    docker-php-ext-configure gd && \
#    docker-php-ext-install -j$(nproc) gd && \
#    docker-php-ext-install exif

CMD php-fpm

EXPOSE 9000