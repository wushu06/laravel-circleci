FROM nginx:stable-alpine

ARG NGINXGROUP
ARG NGINXUSER

ENV NGINXGROUP=www-data
ENV NGINXUSER=www-data

RUN sed -i "s/user www-data/user www-data/g" /etc/nginx/nginx.conf

ADD ./nginx/default.conf /etc/nginx/conf.d/

RUN mkdir -p /var/www/html

RUN adduser -g www-data -s /bin/sh -D www-data; exit 0
