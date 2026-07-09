FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    bash \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zlib-dev \
    icu-dev \
    oniguruma-dev \
    postgresql-dev \
    libwebp-dev

RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp

RUN docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    pgsql \
    gd \
    zip \
    intl \
    mbstring \
    exif

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

ARG UID
ARG GID

RUN addgroup -g ${GID} appgroup \
    && adduser -D -u ${UID} -G appgroup appuser

USER appuser
