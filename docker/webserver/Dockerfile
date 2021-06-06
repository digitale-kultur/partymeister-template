FROM ubuntu:20.04

LABEL maintainer="Taylor Otwell"

ARG WWWGROUP

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \
    && apt-get install -y wget gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python2 \
    && mkdir -p ~/.gnupg \
    && chmod 600 ~/.gnupg \
    && echo "disable-ipv6" >> ~/.gnupg/dirmngr.conf \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys E5267A6C \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys C300EE8C \
    && echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu focal main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get install -y php8.0-cli php8.0-dev \
       php8.0-pgsql php8.0-sqlite3 php8.0-gd \
       php8.0-curl php8.0-memcached \
       php8.0-imap php8.0-mysql php8.0-mbstring \
       php8.0-xml php8.0-zip php8.0-bcmath php8.0-soap \
       php8.0-intl php8.0-readline \
       php8.0-msgpack php8.0-igbinary php8.0-ldap \
       php8.0-redis \
    && apt-get install -y redis-server ffmpeg \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
#    && curl -sL https://deb.nodesource.com/setup_15.x | bash - \
#    && apt-get install -y nodejs \
#    && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
#    && echo "deb https://dl.yarnpkg.com/debian/ stable main" > /etc/apt/sources.list.d/yarn.list \
#    && apt-get update \
#    && apt-get install -y yarn \
    && apt-get install -y mysql-client \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | apt-key add -
RUN sh -c 'echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google-chrome.list'
RUN apt update && apt install -y google-chrome-stable

ENV CHROMEDRIVER_VERSION 90.0.4430.24
ENV CHROMEDRIVER_DIR /chromedriver
RUN mkdir $CHROMEDRIVER_DIR

# Download and install Chromedriver
RUN wget -q --continue -P $CHROMEDRIVER_DIR "https://chromedriver.storage.googleapis.com/$CHROMEDRIVER_VERSION/chromedriver_linux64.zip"
RUN unzip $CHROMEDRIVER_DIR/chromedriver* -d $CHROMEDRIVER_DIR

COPY ./webserver/config/nginx.conf /opt/docker/etc/nginx/vhost.conf
COPY ./webserver/config/php.ini /opt/docker/etc/php/php.ini
COPY ./webserver/config/laravel-websockets.conf /opt/docker/etc/supervisor.d/laravel-websockets.conf
COPY ./webserver/config/redis.conf /opt/docker/etc/supervisor.d/redis.conf

COPY ./webserver/config/redis-conf-addendum.txt /tmp/redis-conf-addendum.txt
RUN cat /tmp/redis-conf-addendum.txt >> /etc/redis/redis.conf

COPY ./webserver/config/init.sh /opt/docker/provision/entrypoint.d/25-partymeister.sh
RUN chmod +x /opt/docker/provision/entrypoint.d/25-partymeister.sh
#RUN chmod -R 777 /composer

COPY ./webserver/config/pm-installation.sh /tmp/pm-installation.sh
RUN chmod +x /tmp/pm-installation.sh

RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.0

#RUN groupadd --force -g $WWWGROUP sail
#RUN useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 sail

#COPY start-container /usr/local/bin/start-container
#COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
#COPY php.ini /etc/php/8.0/cli/conf.d/99-sail.ini
#RUN chmod +x /usr/local/bin/start-container

#EXPOSE 8000

#ENTRYPOINT ["start-container"]


#FROM webdevops/php-nginx-dev:8.0
#
#RUN apt update
#
## Install composer
#ENV COMPOSER_HOME /composer
#ENV PATH ./vendor/bin:/composer/vendor/bin:$PATH
#ENV COMPOSER_ALLOW_SUPERUSER 1
#RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer
#
##RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
##RUN apt install -y nodejs
#
#RUN apt install -y procps
#RUN apt install -y redis-server
#RUN apt install -y ffmpeg
#RUN apt install -y libmagick++-dev
##RUN pecl install imagick
#
#
##RUN npm install -g laravel-echo-server
#
#RUN wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | apt-key add -
#RUN sh -c 'echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google-chrome.list'
#RUN apt update && apt install -y google-chrome-stable
#
#ENV CHROMEDRIVER_VERSION 90.0.4430.24
#ENV CHROMEDRIVER_DIR /chromedriver
#RUN mkdir $CHROMEDRIVER_DIR
#
## Download and install Chromedriver
#RUN wget -q --continue -P $CHROMEDRIVER_DIR "https://chromedriver.storage.googleapis.com/$CHROMEDRIVER_VERSION/chromedriver_linux64.zip"
#RUN unzip $CHROMEDRIVER_DIR/chromedriver* -d $CHROMEDRIVER_DIR
#
#COPY ./webserver/config/nginx.conf /opt/docker/etc/nginx/vhost.conf
#COPY ./webserver/config/php.ini /opt/docker/etc/php/php.ini
#COPY ./webserver/config/laravel-websockets.conf /opt/docker/etc/supervisor.d/laravel-websockets.conf
#COPY ./webserver/config/redis.conf /opt/docker/etc/supervisor.d/redis.conf
#
#COPY ./webserver/config/redis-conf-addendum.txt /tmp/redis-conf-addendum.txt
#RUN cat /tmp/redis-conf-addendum.txt >> /etc/redis/redis.conf
#
#COPY ./webserver/config/init.sh /opt/docker/provision/entrypoint.d/25-partymeister.sh
#RUN chmod +x /opt/docker/provision/entrypoint.d/25-partymeister.sh
#RUN chmod -R 777 /composer
#
#COPY ./webserver/config/pm-installation.sh /tmp/pm-installation.sh
#RUN chmod +x /tmp/pm-installation.sh
#
## TODO
## cron
