FROM php:8.1.2-apache

RUN apt-get update && apt-get install -y \
    libpng-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    libjpeg-dev \
    zip \
    curl \
    cron \
    unzip \
    openssl \
    git \
    nano \
    wget \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql mysqli zip soap bcmath \
    && docker-php-source delete

RUN a2enmod rewrite

# RUN pecl install xdebug-2.4.1 \
#     && docker-php-ext-enable xdebug

# COPY xdebug.ini "$PHP_INI_DIR/conf.d/20-xdebug.ini"

#Instalar composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar Node.js (LTS)
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

CMD cron && /usr/sbin/apache2ctl -D FOREGROUND
