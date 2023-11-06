FROM yiisoftware/yii2-php:8.2-fpm-nginx

RUN docker-php-ext-enable \
    imagick
    
# Configure nginx - http
COPY config/nginx.conf /etc/nginx/nginx.conf
# Configure nginx - default server
COPY config/conf.d /etc/nginx/conf.d/

COPY src/ .
RUN composer install

EXPOSE 8080