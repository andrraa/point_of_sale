FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    bash \
    curl \
    sqlite-dev \
    libzip-dev \
    icu-dev \
    zlib-dev \
    oniguruma-dev

RUN docker-php-ext-install \
    pdo_sqlite \
    sqlite3 \
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
