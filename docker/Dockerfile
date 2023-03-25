FROM dfox288/partymeister-php-81-prod:2.0.1

WORKDIR /var/www
COPY . /var/www

CMD composer install && cp .env.example .env && php artisan key:generate && php artisan storage:link && php artisan migrate --force && service supervisor start && php-fpm
