FROM webdevops/php-nginx:8.5

RUN pecl update-channels \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && pecl clear-cache \
    && rm -rf /tmp/pear

RUN apt update && apt install npm -y
