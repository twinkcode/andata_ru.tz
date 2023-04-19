FROM php:8.0-apache

# Копируем файлы приложения в контейнер
COPY . /var/www/html/

# Устанавливаем зависимости
RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    && docker-php-ext-install zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Устанавливаем зависимости приложения
WORKDIR /var/www/html/
RUN composer install

# Открываем порт для доступа к приложению
EXPOSE 80

# Запускаем сервер Apache
CMD ["apache2-foreground"]
