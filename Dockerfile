FROM php:8.2.9-fpm AS ext-amqp

ENV EXT_AMQP_VERSION=latest

RUN ls -al /usr/local/lib/php/extensions/

FROM php:8.2.9-fpm

RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN curl -sL https://getcomposer.org/installer | php -- --install-dir /usr/bin --filename composer

RUN mkdir -p /var/log/supervisor

WORKDIR /app

RUN apt-get update

RUN apt-get -y install git zip libpq-dev

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli

RUN apt-get -y install redis-server && pecl install redis && docker-php-ext-enable redis

RUN pecl install xdebug

RUN echo 'pm.max_children = 30' >> /usr/local/etc/php-fpm.d/zz-docker.conf

RUN docker-php-ext-configure opcache --enable-opcache && docker-php-ext-install opcache

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && install-php-extensions amqp

CMD ["php-fpm"]