FROM yiisoftware/yii2-php:8.2-fpm-nginx

COPY config/conf.d /etc/nginx/conf.d/

# Configure PHP-FPM
ENV PHP_INI_DIR /etc/php82
COPY config/fpm-pool.conf ${PHP_INI_DIR}/php-fpm.d/www.conf
COPY config/php.ini ${PHP_INI_DIR}/conf.d/custom.ini

COPY src/ .
RUN composer install
RUN php init --env=Development --overwrite=a

EXPOSE 8080