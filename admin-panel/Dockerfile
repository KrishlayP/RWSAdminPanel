FROM php:8.2-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist --optimize-autoloader

COPY . .

RUN composer dump-autoload --optimize \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000

CMD php artisan migrate --force --seed \
    && php artisan storage:link \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php -S 0.0.0.0:${PORT:-10000} -t public
