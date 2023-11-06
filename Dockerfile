FROM yiisoftware/yii2-php:8.2-fpm-nginx-min

# COPY src/ .
# RUN composer install
# RUN php init --env=Development --overwrite=a

RUN cat /etc/nginx/nginx.conf
RUN cat /etc/nginx/conf.d/default.conf
RUN ls /etc/nginx/conf.d

RUN cat /etc/php/php-fpm.d/www.conf
RUN cat /etc/php/php.ini

EXPOSE 8080