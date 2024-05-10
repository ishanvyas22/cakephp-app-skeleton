# Note: This file is only for development purpose.
ARG PHP_VERSION=8.1
ARG COMPOSER_VERSION=2.2
ARG PHP_EXT_INSTALLER_VERSION=1.5

FROM composer:$COMPOSER_VERSION AS composer

FROM mlocati/php-extension-installer:$PHP_EXT_INSTALLER_VERSION AS ext-installer

FROM php:$PHP_VERSION-fpm-alpine

LABEL Maintainer="Ishan Vyas <isvyas@gmail.com>"

ARG DEBUG=false
ENV DEBUG=$DEBUG

ENV DOCKER_CONFIG=${DOCKER_CONFIG:-$HOME/.docker}
ENV DOCKER_COMPOSE_VERSION=v2.12.2

RUN apk update \
  && apk add --no-cache --virtual .deps \
  make \
  automake \
  autoconf \
  gcc \
  g++ \
  curl-dev \
  && apk add --no-cache \
  docker-cli \
  && apk del .deps \
  && rm -rf /var/cache/apk/*

RUN mkdir -p $DOCKER_CONFIG/cli-plugins \
  && ARCH=$(uname -m) && if [ $ARCH == "armv7l" ]; then ARCH="armv7"; fi \
  && curl -SL https://github.com/docker/compose/releases/download/$DOCKER_COMPOSE_VERSION/docker-compose-linux-$ARCH -o $DOCKER_CONFIG/cli-plugins/docker-compose \
  && chmod +x $DOCKER_CONFIG/cli-plugins/docker-compose

COPY --from=ext-installer /usr/bin/install-php-extensions /usr/bin/

RUN chmod +x /usr/bin/install-php-extensions && \
    install-php-extensions intl mysqli pdo_mysql redis

RUN \
  if [ "$DEBUG" == "true" ]; then \
    mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"; \
  else \
    mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"; \
  fi

COPY --chown=www-data:www-data . /var/www/html

RUN chmod +x /var/www/html/bin/install

RUN mkdir -p /.composer

WORKDIR /var/www/html

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN composer install --no-ansi --no-interaction --optimize-autoloader \
    `if [ "$DEBUG" != "true" ]; then echo "--no-dev"; fi`

ENV PATH="${PATH}:/home/www-data/.composer/vendor/bin"

EXPOSE 9000
