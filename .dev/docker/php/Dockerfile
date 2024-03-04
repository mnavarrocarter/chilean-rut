FROM alpine:3.18 as base

ARG UID=1000
ARG USER=mnavarro
ARG COMPOSER_VERSION=2.7.0

# Create a development user
RUN adduser $USER --disabled-password --home /$USER --uid $UID

# Install PHP Extensions
RUN apk add --no-cache \
    php82-cli \
    php82-phar \
    php82-mbstring \
    php82-json \
    php82-zip \
    php82-openssl \
    php82-dom \
    php82-xml \
    php82-soap \
    php82-session \
    php82-xmlwriter \
    php82-sockets \
    php82-simplexml \
    php82-bcmath \
    php82-xmlreader \
    php82-tokenizer \
    php82-iconv \
    php82-sodium \
    php82-fileinfo \
    php82-curl \
    php82-ctype \
    php82-pcntl \
    php82-posix

# Link php82 to php
RUN ln -s /usr/bin/php82 /usr/bin/php

# Add wget to make requests
RUN apk add --no-cache wget

# Download and install composer
RUN wget -O /usr/bin/composer https://github.com/composer/composer/releases/download/$COMPOSER_VERSION/composer.phar && \
    chmod +x /usr/bin/composer

FROM base as dev

# Install and Configure XDebug
RUN apk add --no-cache php82-pecl-xdebug
COPY ./xdebug.ini /etc/php82/conf.d/60_xdebug.ini