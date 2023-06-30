FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

RUN apk --update --no-cache add git
RUN docker-php-ext-install pdo_mysql

RUN apk update
RUN apk upgrade
RUN apk add bash

EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80"]