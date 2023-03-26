FROM dfox288/partymeister-php-81-prod:2.0.1

WORKDIR /var/www
COPY . /var/www

RUN cp .env.example .env
RUN mkdir storage && \
    mkdir -p storage/framework/{sessions,views,cache} && \
    chmod -R 775 storage/framework

RUN composer install --no-dev
RUN php artisan key:generate

RUN rm -rf storage

CMD cd /app && php artisan storage:link && service supervisor start && php-fpm
