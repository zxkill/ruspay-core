#!/usr/bin/env bash
set -e

echo "⏳ Waiting for Postgres…"
until pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME"; do
  sleep 1
done
echo "✅ Postgres is up"

composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction --no-progress

php artisan migrate --force

exec php-fpm
