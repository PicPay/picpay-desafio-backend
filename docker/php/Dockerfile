FROM php:7.4-fpm-alpine

ARG HOST_UID=${HOST_UID}
ARG HOST_USER=${HOST_USER}

# Install dev dependencies
RUN apk add --no-cache --virtual .build-deps autoconf \
    curl-dev \
    libtool \
    libxml2-dev

# Install production dependencies
RUN apk add --no-cache \
    bash \
    curl \
    freetype-dev \
    g++ \
    gcc \
    git \
    imagemagick \
    libc-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    make \
    mysql-client \
    oniguruma-dev \
    openssh-client \
    zlib-dev

# Install PECL and PEAR extensions
RUN pecl install \
    xdebug \
    redis

# Enable PECL and PEAR extensions
RUN docker-php-ext-enable \
    xdebug \
    redis

# Configure php extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Install php extensions
RUN docker-php-ext-install \
    bcmath \
    calendar \
    curl \
    exif \
    gd \
    iconv \
    mbstring \
    pdo \
    pdo_mysql \
    pcntl \
    tokenizer \
    xml \
    zip

# Install composer
ENV COMPOSER_HOME /composer
ENV PATH ./vendor/bin:/composer/vendor/bin:$PATH
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

# Install PHP CS Fixer
RUN curl -L https://cs.symfony.com/download/php-cs-fixer-v2.phar -o php-cs-fixer
RUN chmod a+x php-cs-fixer
RUN mv php-cs-fixer /usr/local/bin/php-cs-fixer

# Cleanup dev dependencies
RUN apk del -f .build-deps

RUN [ "${HOST_USER}" == "root" ] || \
    (adduser -h /home/${HOST_USER} -D -u ${HOST_UID} ${HOST_USER} \ 
    && mkdir -p /home/$HOST_USER \
    && chown -R "${HOST_UID}:${HOST_UID}" /home/${HOST_USER})