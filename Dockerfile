FROM zacksleo/docker-composer:alpine
WORKDIR /var/www/html
COPY . /var/www/html
VOLUME ["/var/www/html"]
