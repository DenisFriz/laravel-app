# Dockerfile
FROM php:8.2-cli

# Устанавливаем зависимости
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl netcat-openbsd

# Расширения PHP
RUN docker-php-ext-install pdo_mysql mbstring bcmath gd

# Установка php-redis
RUN pecl install redis \
    && docker-php-ext-enable redis

# Устанавливаем composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Копируем Laravel проект
COPY src/ /var/www

# Устанавливаем зависимости Laravel
RUN composer install

# Копируем entrypoint
COPY docker/entrypoint.sh ./docker/entrypoint.sh
RUN chmod +x ./docker/entrypoint.sh

ENTRYPOINT ["./docker/entrypoint.sh"]