FROM php:8.2-fpm

# Install dependencies for Laravel
RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      git && \
      docker-php-ext-install pdo_mysql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

ENV COMPOSER_ALLOW_SUPERUSER=1
# Composer installation
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --install-dir=/usr/local/bin

COPY . /var/www
WORKDIR /var/www

# Install Laravel dependencies
RUN composer install

RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www/storage

# Expose port for Laravel application (adjust if needed)
EXPOSE 9000

USER valeriyagodlevskaya

# Start PHP-FPM process
CMD ["php-fpm"]
