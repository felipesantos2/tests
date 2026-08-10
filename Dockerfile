FROM php:8.5-alpine3.24

ENV APP_DIR /app

RUN echo "UTC" > /etc/timezone

WORKDIR $APP_DIR

COPY . .

RUN apk update && apk upgrade && apk clean cache

RUN apk add --no-cache build-base ca-certificates openssl tar unzip zip

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apk add --no-cache bash \
    git \
    curl \
    git \
    openssl-dev \
    libzip-dev \
    zlib-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    icu-dev \
    nodejs npm

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    rm -rf composer-setup.php

EXPOSE 8000
