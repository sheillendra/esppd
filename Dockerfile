FROM yiisoftware/yii2-php:8.2-fpm-nginx

COPY config/conf.d /etc/nginx/conf.d/

COPY src/ .
RUN composer install
RUN php init --env=Development --overwrite=a

EXPOSE 8080