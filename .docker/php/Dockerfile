FROM php:7.2-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN apt-get clean
RUN apt-get update && apt-get install -y \
        apt-utils \
        vim \
        git \
        unzip \
        zlib1g-dev \
        libbz2-dev \
        mariadb-client \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pdo pdo_mysql zip bz2 \
    && docker-php-ext-install opcache \
    && docker-php-ext-install pcntl \
    && a2enmod rewrite


#gd
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev  \
        libpng-dev  \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

# xdebug
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug

# apcu
RUN pecl install apcu && \
    docker-php-ext-enable apcu

# Install intl
RUN apt-get update \
  && apt-get install -y zlib1g-dev libicu-dev g++ \
  && docker-php-ext-configure intl \
  && docker-php-ext-install -j$(nproc) intl

# Install XSL
RUN apt-get update && apt-get install -y libxslt-dev
RUN docker-php-ext-install xsl

# imap
RUN apt-get update && apt-get install -y libc-client-dev libkrb5-dev
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap

# Install Composer and make it available in the PATH
ENV COMPOSER_ALLOW_SUPERUSER 1

# install composer
RUN curl -o /tmp/composer-setup.php https://getcomposer.org/installer \
    && curl -o /tmp/composer-setup.sig https://composer.github.io/installer.sig \
    && php -r "if (hash('SHA384',file_get_contents('/tmp/composer-setup.php'))!==trim(file_get_contents('/tmp/composer-setup.sig'))){unlink('/tmp/composer-setup.php');echo 'Invalid installer'.PHP_EOL; exit(1);}" \
    && php /tmp/composer-setup.php \
        --no-ansi \
        --install-dir=/usr/local/bin \
        --filename=composer \
        --snapshot \
    && rm -f /tmp/composer-setup. *

RUN composer --version
RUN composer global require codeception/codeception

COPY php-ini-overrides.ini /usr/local/etc/php/conf.d/99-overrides.ini

WORKDIR "/var/www/html"
