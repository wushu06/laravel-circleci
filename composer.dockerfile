FROM composer:2

ARG PHPGROUP
ARG PHPUSER

ENV PHPGROUP=www-data
ENV PHPUSER=www-data

RUN adduser -g www-data -s /bin/sh -D www-data; exit 0

WORKDIR /var/www/html
