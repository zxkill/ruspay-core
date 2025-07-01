#!/usr/bin/env bash
set -e

echo "⏳ Waiting for Postgres…"
until pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME"; do
  sleep 1
done
echo "✅ Postgres is up"

if [ "$APP_ENV" = "production" ]; then
    composer install --no-dev --optimize-autoloader --no-interaction
  else
    composer install --optimize-autoloader --no-interaction
  fi

php artisan migrate --force

exec php-fpm
