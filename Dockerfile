FROM php:7.4-apache

ENV COMPOSER_ALLOW_SUPERUSER=1

EXPOSE 80
WORKDIR /lackSMS

RUN apt-get update -qq && \
    apt-get install -qy \
    git \
    gnupg \
    unzip \
    zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY conf/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY conf/apache.conf /etc/apache2/conf-available/lackSMS.conf
COPY .env.example /lackSMS/.env
COPY composer.json /lackSMS/composer.json
COPY postMessage.php /lackSMS/postMessage.php
COPY robots.txt /lackSMS/robots.txt

RUN composer install

RUN a2enmod rewrite remoteip && \
    a2enconf lackSMS
