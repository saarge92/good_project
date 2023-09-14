FROM php:8.1-fpm

RUN apt update && apt install -y git g++ wget zlib1g-dev libicu-dev zip libzip-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql pcntl \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-configure pcntl --enable-pcntl

RUN git clone  https://github.com/edenhill/librdkafka.git \
    && cd librdkafka \
    && ./configure \
    && make \
    && make install

RUN pecl channel-update pecl.php.net \
    && pecl install rdkafka \
    && docker-php-ext-enable rdkafka \
    && rm -rf /librdkafka

WORKDIR /var/www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN wget https://get.symfony.com/cli/installer -O - | bash
