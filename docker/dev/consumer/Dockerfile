FROM php:7.4-fpm-alpine

ARG FRONT_HOST
ARG NAME
ENV NAME=${NAME}
RUN apk update && apk add curl wget gettext

###################
#       PHP       #
###################

# copy php config
COPY config-php/php.ini /usr/local/etc/php/php.ini

# Install PHP extentions
RUN docker-php-source extract \
    && apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS postgresql-dev zlib-dev libzip-dev libpng-dev icu-dev openssl-dev zip \
    && docker-php-ext-install -j$(nproc) pgsql \
    && docker-php-ext-install -j$(nproc) pdo_pgsql \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-install -j$(nproc) opcache \
    && docker-php-ext-install -j$(nproc) bcmath \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-source delete

RUN echo $' \n\
extension=apcu.so \n\
apc.enable=1 \n\
apc.enable_cli=1' > /usr/local/etc/php/conf.d/docker-php-ext-apcu.ini

# Set timezone
RUN ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# library for use composer in multithread
RUN composer global require hirak/prestissimo

# Install Symfony CLI
RUN apk add bash git && \
    wget https://get.symfony.com/cli/installer -O - | bash && \
    mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN mkdir -p /www/${NAME}

###################
# Launch Services #
###################

CMD php bin/console app:run

WORKDIR /www/${NAME}