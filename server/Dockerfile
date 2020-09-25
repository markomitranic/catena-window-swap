FROM markomitranic/sosko-aio-php:7.4 AS base
ENTRYPOINT ["bash", "/app/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY config/php.ini /usr/local/etc/php/conf.d/z-custom.ini
COPY config/default.conf /etc/nginx/conf.d/default.conf
COPY ./entrypoint.sh /app/entrypoint.sh
ARG BLACKFIRE_AGENT_IP=blackfire_agent
RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/amd64/$version \
    && mkdir -p /tmp/blackfire \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get ('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://$BLACKFIRE_AGENT_IP:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
    && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz

FROM base AS prod
COPY ./src /app/src

FROM base AS dev
# Install XDebug (Optional)
ARG XDEBUG_ACTIVE=0
ARG XDEBUG_HOST_IP=host.docker.internal
RUN if [ "$XDEBUG_ACTIVE" -eq 1 ] ; then \
        yes | pecl install xdebug \
        && rm -rf /tmp/pear \
        && docker-php-ext-enable xdebug \
        && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.remote_host=$XDEBUG_HOST_IP" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.idekey=WINDOWSWAP-DEBUG" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    ; fi
RUN rm -rf /app/src/*
