FROM php:8.4-fpm

WORKDIR /app

# Instalar dependencias necessárias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    nodejs \
    iputils-ping \
    netcat-openbsd \
    npm

# Limpar cache do apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP necessárias
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Configurar Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN echo "opcache.enable=0" >> /usr/local/etc/php/conf.d/99_php.ini; \
     echo "opcache.interned_strings_buffer=72" >> /usr/local/etc/php/conf.d/99_php.ini; \
     echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/50_xdebug.ini; \
     echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/50_xdebug.ini; \
     echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/50_xdebug.ini; \
     echo "xdebug.log=/app/storage/logs/xdebug.log" >> /usr/local/etc/php/conf.d/50_xdebug.ini; \
     echo "xdebug.log_level=7" >> /usr/local/etc/php/conf.d/50_xdebug.ini; \
     echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/50_xdebug.ini; \
     echo "xdebug.discover_client_host=true" >> /usr/local/etc/php/conf.d/50_xdebug.ini; \
     echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/50_xdebug.ini;

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

EXPOSE 9000 8080 5173 9003

CMD ["php-fpm"]
