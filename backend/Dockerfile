FROM php:8.3-fpm

# Install Composer
ENV COMPOSER_VERSION 2.7.6

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=$COMPOSER_VERSION

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    apt-transport-https \
    build-essential \
    openssl \
    nginx \
    supervisor \
    cron \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libpng-dev \
    libssl-dev \
    libzip-dev \
    libicu-dev \
    unzip \
    zip \
    nodejs \
    git \
    && apt-get clean \
    && pecl install redis \
    && docker-php-ext-configure zip \
    && docker-php-ext-install \
    -j$(nproc) gd \
    exif \
    opcache \
    pdo_mysql \
    pdo_pgsql \
    pgsql \
    pcntl \
    zip \
    && docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-enable redis \
    && docker-php-ext-install bcmath \
    && rm -rf /var/lib/apt/lists/*;

COPY ./composer.json /var/www/
COPY ./composer.lock /var/www/

RUN apt-get update \
    && apt-get -y install jq

RUN mkdir -p /var/www/storage/framework /var/www/storage/framework/views /var/www/storage/framework/sessions /var/www/storage/framework/cache

RUN --mount=type=secret,id=composer_auth,dst=/var/www/auth.json composer install --working-dir=/var/www --no-scripts

COPY ./dockerfiles/php.ini /usr/local/etc/php/conf.d/laravel.ini

COPY ./dockerfiles/nginx.conf /etc/nginx/nginx.conf

WORKDIR /var/www

COPY . .

RUN composer dump-autoload

RUN chown -R www-data:www-data /var/www

RUN chmod -R 755 /var/www/storage

EXPOSE 80

RUN ["chmod", "+x", "./post_deploy.sh"]

CMD ["sh", "post_deploy.sh"]
