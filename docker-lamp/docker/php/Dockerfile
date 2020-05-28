FROM php:7.2-apache

COPY php.ini /usr/local/etc/php/
COPY httpd.conf /etc/apache2/conf-enabled/

RUN a2enmod rewrite
RUN service apache2 restart

RUN apt-get update \
  && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev libmcrypt-dev \
  && docker-php-ext-install pdo_mysql mysqli mbstring gd iconv

EXPOSE 80
