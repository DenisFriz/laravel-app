#!/bin/sh
set -e

if [ ! -f .env ]; then
  echo "Creating .env file..."
  cp .env.example .env
fi


echo "Waiting for MySQL..."
until nc -z mysql 3306; do
  sleep 1
done

echo "Waiting for Redis..."
until nc -z redis 6379; do
  sleep 1
done


if [ ! -d "/var/www/vendor" ]; then
  composer install --no-interaction --optimize-autoloader
fi

php artisan migrate --force

php artisan serve --host=0.0.0.0 --port=8000