ARG PHP_VERSION=7.2
FROM php:${PHP_VERSION}-fpm AS app-php_base

LABEL maintener="9268494+azzra@users.noreply.github.com"

ARG APCU_VERSION=5.1.18

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        ssh \
        libzip-dev \
        zip \
        unzip \
        libpq-dev \
    && rm -Rf /var/lib/apt/lists/*

RUN pecl install apcu mongodb xdebug \
    && docker-php-ext-enable apcu mongodb xdebug \
    && rm -rf /tmp/pear

RUN docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install -j$(nproc) \
        opcache \
        zip \
        mbstring \
        pdo_pgsql

# Composer
# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_MEMORY_LIMIT -1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV PATH="${PATH}:/root/.composer/vendor/bin"

FROM app-php_base AS app-php_dev
RUN ln -s $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
COPY docker/php/conf.d/app.dev.ini $PHP_INI_DIR/conf.d/app.ini

FROM app-php_base AS app-php_prod
ARG APP_ENV=prod

COPY composer.json composer.lock symfony.lock ./
RUN set -eux; \
	composer install --prefer-dist --no-autoloader --no-scripts --no-progress --no-suggest; \
	composer clear-cache

COPY .env .env
COPY bin bin/
COPY config config/
COPY public public/
COPY src src/
COPY templates templates/

RUN set -eux; \
	mkdir -p var/cache var/log; \
	composer dump-autoload --classmap-authoritative; \
        composer run-script post-install-cmd; \
    chmod +x bin/console; sync

COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint
