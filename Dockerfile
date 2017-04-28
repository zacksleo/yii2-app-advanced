FROM zacksleo/docker-composer

WORKDIR /var/www/html

COPY . /var/www/html

RUN mkdir frontend/runtime frontend/web/assets frontend/web/galleries backend/runtime backend/web/assets console/runtime \
&& chown www-data:www-data frontend/runtime frontend/web/assets frontend/web/galleries backend/runtime backend/web/assets backend/rbac console/runtime

VOLUME ["/var/www/html"]
