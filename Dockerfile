FROM php:8.1-apache

RUN a2enmod rewrite \
    && a2enmod headers

RUN apt-get update \
  && apt-get install -y libzip-dev git wget --no-install-recommends \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install pdo mysqli pdo_mysql zip;

RUN wget https://getcomposer.org/download/2.2.4/composer.phar \
    && mv composer.phar /usr/bin/composer && chmod +x /usr/bin/composer

COPY ./docker/000-default.conf /etc/apache2/sites-enabled/000-default.conf

WORKDIR /var/www/mini-project/

CMD ["apache2-foreground"]


