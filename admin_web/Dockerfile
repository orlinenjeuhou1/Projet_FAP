FROM webdevops/php-nginx:8.2

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_DISABLE_NETWORK=1

# Symfony expects this as the root
ENV WEB_DOCUMENT_ROOT=/var/www/public

WORKDIR /var/www

COPY . .

# Permissions
RUN chown -R application:application /var/www \
 && chmod -R 755 /var/www/public





