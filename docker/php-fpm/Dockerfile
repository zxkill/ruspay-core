FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git zip unzip \
    libpq-dev    \
    postgresql-client \
    && docker-php-ext-install pdo pdo_pgsql opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
#RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction --no-progress

COPY ./docker/php-fpm/entrypoint.sh  /entrypoint.sh

RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]