FROM bitnami/laravel:11.5.1

WORKDIR /var/www

COPY . .

RUN composer install

COPY .env.example .env

RUN php artisan key:generate

RUN php artisan config:cache

RUN php artisan migrate

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
