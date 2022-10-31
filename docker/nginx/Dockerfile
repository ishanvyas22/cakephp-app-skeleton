# Note: This file is for production purpose.
ARG NGINX_VERSION=1.23

FROM nginx:$NGINX_VERSION-alpine

LABEL Maintainer="Ishan Vyas <isvyas@gmail.com>"

COPY ./default.conf /etc/nginx/conf.d/default.conf
COPY ../../. /var/www/html
