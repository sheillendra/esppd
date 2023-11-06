FROM yiisoftware/yii2-php:8.2-fpm-nginx

RUN echo pwd: `pwd` && echo ls: `ls`  # outputs:
                                      # pwd: /
                                      # ls:

RUN composer install