FROM yiisoftware/yii2-php:8.2-fpm-nginx

COPY config/conf.d /etc/nginx/conf.d/

# Configure PHP-FPM
COPY config/fpm-pool.conf /etc/php-fpm.d/www.conf
COPY config/php.ini /etc/php/conf.d/custom.ini

COPY src/ .
RUN composer install
RUN php init --env=Development --overwrite=a

EXPOSE 8080