FROM php:8.1

RUN apt-get update -y && apt-get install -y libmcrypt-dev
RUN apt-get install -y git
RUN apt-get install -y libzip-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo zip

WORKDIR /srv
COPY . /srv

RUN tar -xvf archive-laravel.tar.gz

WORKDIR /srv/serveurapi-develop


RUN composer install
RUN cp .env.example .env
RUN php artisan key:generate
RUN touch database/database.sqlite
RUN php artisan jwt:secret
RUN php artisan migrate:fresh
RUN php artisan db:seed

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
