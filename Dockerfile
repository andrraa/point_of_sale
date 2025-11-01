FROM node:20-alpine AS node_builder

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev sqlite3 \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_sqlite mbstring exif pcntl bcmath gd \
    && docker-php-ext-enable opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/denai-murah

COPY . .

COPY --from=node_builder /app/public /var/www/denai-murah/public
COPY --from=node_builder /app/node_modules /var/www/denai-murah/node_modules

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/denai-murah && \
    chmod -R 775 /var/www/denai-murah/storage /var/www/denai-murah/bootstrap/cache

COPY ./entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
