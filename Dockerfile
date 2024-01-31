FROM php:8.2-apache

RUN docker-php-ext-install mysqli

RUN chmod -R 777 .

RUN service apache2 restart