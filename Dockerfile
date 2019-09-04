FROM php:7.3

RUN pecl install swoole && echo "extension=swoole.so" > /usr/local/etc/php/conf.d/swoole.ini

WORKDIR /var/www/html