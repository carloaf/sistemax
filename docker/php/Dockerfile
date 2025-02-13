# Base PHP com Apache
FROM php:8.4-apache

# Atualizar pacotes e instalar extensões
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    vim \
    openssl \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && a2enmod ssl rewrite

# Instalar Node.js e npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Xdebug e Opcache
RUN pecl install xdebug && docker-php-ext-enable xdebug \
    && docker-php-ext-enable opcache

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuração de PHP.ini
COPY docker/php/php.ini /usr/local/etc/php/

# Configuração do Apache SSL
COPY docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/apache/ssl/server.crt /etc/apache2/ssl/server.crt
COPY docker/apache/ssl/server.key /etc/apache2/ssl/server.key

# Habilitar site SSL
RUN a2ensite 000-default.conf

# Ajustar permissões do diretório de trabalho
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Pasta de trabalho
WORKDIR /var/www/html