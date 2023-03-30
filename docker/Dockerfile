FROM dfox288/partymeister-php-81-prod:2.0.1

WORKDIR /var/www
COPY . /var/www

RUN cp .env.example .env
RUN composer install --no-dev
RUN php artisan key:generate

USER www-data
COPY docker/config/crontab-www-data /tmp

RUN crontab /tmp/crontab-www-data

USER root

CMD service supervisor start && php-fpm
