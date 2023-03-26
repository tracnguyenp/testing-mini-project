FROM npbtrac/php:7.4-x86
LABEL Maintainer="Trac Nguyen <npbtrac@yahoo.com>" \
      Description="Lightweight container with Nginx 1.18 & PHP 7.4 based on Alpine Linux."

# Install packages
RUN apk update
RUN apk --no-cache add nginx supervisor \
    php7-fpm php7-tokenizer php7-pdo php7-pdo_mysql php7-pdo_pgsql

# Switch to use a root user from here on
USER root

# Customize nginx config
COPY dev-docker/config/nginx/nginx.conf /etc/nginx/nginx.conf

# Custom .ini
COPY dev-docker/config/php/custom.ini /etc/php7/conf.d/custom.ini

# Customize php-fpm pool config
COPY dev-docker/config/php/fpm/www.conf /etc/php7/php-fpm.d/www.conf

# Configure supervisord
COPY dev-docker/config/others/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Composer
RUN curl -O https://getcomposer.org/download/latest-stable/composer.phar
RUN chmod +x composer.phar
RUN mv composer.phar /usr/local/bin/composer

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nobody.nobody /run && \
  chown -R nobody.nobody /var/lib/nginx && \
  chown -R nobody.nobody /var/log/nginx

######## Update below here for each particular project
COPY ./ /var/www/html

WORKDIR /var/www/html
RUN rm -rf ./vendor >/dev/null 2>&1
RUN XDEBUG_MODE=off composer install --no-dev --ignore-platform-reqs

######## Below

# Add another user to own the files to not allow nobody to modify files
RUN adduser -D -H -G root devuser
RUN chown -R devuser:root /var/www/html
RUN chmod -R 777 /var/www/html/bootstrap/cache /var/www/html/storage/*

# Switch to use a non-root user from here on
USER nobody

# Expose the port nginx is reachable on
EXPOSE 8080

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# For output logs to the console
RUN ln -sf /dev/stdout /var/log/nginx/access.log && ln -sf /dev/stderr /var/log/nginx/error.log

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping

WORKDIR /var/www/html
