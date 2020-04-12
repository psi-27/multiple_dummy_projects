FROM wodby/wordpress-php:7.4-dev

USER root

RUN apk --no-cache add \
        autoconf \
        build-base \
        geoip \
        geoip-dev; \
        pecl install geoip-1.1.1; \
        docker-php-ext-enable geoip

USER wodby

ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["sudo", "-E", "LD_PRELOAD=/usr/lib/preloadable_libiconv.so", "php-fpm"]
