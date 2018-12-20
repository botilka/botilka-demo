FROM php:7.2-fpm-stretch

# Install Git
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
	    ssh \
    && rm -Rf /var/lib/apt/lists/*

# PHP config
ADD docker/php/php.ini /usr/local/etc/php/php.ini

RUN pecl install apcu mongodb xdebug \
    && docker-php-ext-enable apcu mongodb xdebug \
    && rm -rf /tmp/pear

RUN docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install opcache

ARG BUILD_DEPS="libicu-dev libfreetype6-dev libjpeg62-turbo-dev zlib1g-dev"
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        $BUILD_DEPS \
        libfreetype6 \
        libicu57 \
        libjpeg62-turbo \
        libpq-dev \
        zlib1g \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) \
        intl \
        mbstring \
        pdo_pgsql \
        gd \
        zip \
    && apt-get purge -y --auto-remove $BUILD_DEPS

# Composer
# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV PATH="${PATH}:/root/.composer/vendor/bin"

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

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]
