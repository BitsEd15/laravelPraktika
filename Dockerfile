FROM php:8.3-apache

#Обновление репозиториев. Нужно чтобы автомитечески обновить версии пакетов доступных нам -y это типо ес, да,
RUN apt-get update -y

# Установливается библиотека, для работы с постгресом
RUN apt-get install -y libpq-dev

#Подключение зависимостей с субд
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install pgsql

# Устанавливается зависимость композера
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# устанавливается git
RUN apt install git -y 
# apt - пакетный менеджер в linux
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install zip

RUN apt-get update && apt-get install -y nano

#включение модуля перенаправлений
RUN a2enmod rewrite
