FROM php:7.4-fpm-alpine

ARG FRONT_HOST
ARG NAME
ENV NAME=${NAME}
RUN apk update && apk add curl wget gettext

###################
# Certificate SSL #
###################

# Install openssl
RUN apk update && \
  apk add openssl

# Generate SSL keys for nginx
# see: https://www.digitalocean.com/community/tutorials/how-to-create-a-self-signed-ssl-certificate-for-nginx-in-ubuntu-16-04
# TODO Change 1024 to 2048
RUN [[ ! -f /etc/ssl/certs/dhparam.pem ]] && openssl dhparam -out /etc/ssl/certs/dhparam.pem 1024
RUN [[ ! -f /etc/ssl/certs/${FRONT_HOST}.crt ]] && openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
  -keyout /etc/ssl/private/${FRONT_HOST}.key \
  -out /etc/ssl/certs/${FRONT_HOST}.crt \
  -subj "/C=FR/ST=Savoie/L=Grenoble/O=yst/OU=yst/CN=${FRONT_HOST}"

VOLUME /etc/ssl

###################
#      Nginx      #
###################

# Install Nginx
RUN apk update && \
  apk add nginx && \
  adduser -D -g 'www' www && \
  mkdir -p /www/${NAME} && \
  chown -R www:www /var/lib/nginx && \
  chown -R www:www /www

# Copy nginx config
COPY config-nginx/nginx.conf /tmp/nginx/nginx.conf
COPY config-nginx/snippets /tmp/nginx/snippets/
RUN mkdir -p /etc/nginx/snippets/
# Change ENV by value
RUN envsubst '\${FRONT_HOST} \${NAME}' < /tmp/nginx/nginx.conf > /etc/nginx/nginx.conf
RUN envsubst '\${FRONT_HOST}' < /tmp/nginx/snippets/self-signed.conf > /etc/nginx/snippets/self-signed.conf
RUN envsubst '\${FRONT_HOST}' < /tmp/nginx/snippets/ssl-params.conf > /etc/nginx/snippets/ssl-params.conf

###################
#       PHP       #
###################

# copy php config
COPY config-php/php.ini /usr/local/etc/php/php.ini
COPY config-php/php_fpm.conf /etc/php7/php_fpm.conf
COPY config-php/php-fpm.d /etc/php7/php-fpm.d

# Install PHP extentions
RUN docker-php-source extract \
    && apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS postgresql-dev zlib-dev libzip-dev libpng-dev icu-dev openssl-dev zip \
    && docker-php-ext-install -j$(nproc) pgsql \
    && docker-php-ext-install -j$(nproc) pdo_pgsql \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-install -j$(nproc) opcache \
    && docker-php-ext-install -j$(nproc) zip \
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

###################
# Launch Services #
###################

CMD \
  mkdir -p /var/log/nginx/${NAME}/ && \
  chmod -R 0777 /var/log/nginx/${NAME}/ && \
  mkdir -p /var/tmp/nginx/ && \
  chmod -R 0777 /var/tmp/nginx/ && \
  /usr/sbin/nginx && \
  php-fpm -R --nodaemonize

WORKDIR /www/${NAME}