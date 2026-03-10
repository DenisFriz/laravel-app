#!/bin/sh
set -e

set -e

echo "Waiting for MySQL..."
until nc -z mysql 3306; do
  sleep 1
done

echo "Waiting for Redis..."
until nc -z redis 6379; do
  sleep 1
done

php artisan migrate --force

php artisan serve --host=0.0.0.0 --port=8000