FROM webdevops/php-nginx:8.4

RUN pecl update-channels \
    && pecl install xdebug-3.4.1 \
    && docker-php-ext-enable xdebug \
    && pecl clear-cache \
    && rm -rf /tmp/pear
