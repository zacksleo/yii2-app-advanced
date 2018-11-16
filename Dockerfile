FROM zacksleo/docker-composer:alpine
WORKDIR /var/www/html
COPY supervisord.conf /etc/supervisor/conf.d/
COPY . /var/www/html
ADD crontab /var/spool/cron/crontabs/root
RUN chmod 0644 /var/spool/cron/crontabs/root
COPY . /var/www/html
VOLUME ["/var/www/html"]
ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/conf.d/supervisord.conf"]