# Base PHP com Apache
FROM php:8.4-apache

# Atualizar pacotes e instalar pacotes necessários
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    vim \
    nano \
    openssl \
    curl \
    && rm -rf /var/lib/apt/lists/* 

# Instalar extensões PHP
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    zip

# Instalar mkcert
RUN curl -L -o /usr/local/bin/mkcert https://github.com/FiloSottile/mkcert/releases/download/v1.4.4/mkcert-v1.4.4-linux-amd64 \
    && chmod +x /usr/local/bin/mkcert

# Criar diretório para certificados SSL
RUN mkdir -p /etc/apache2/ssl

# Habilitar módulos necessários do Apache
RUN a2enmod proxy proxy_http ssl rewrite

# Instalar a CA local e gerar certificados
RUN mkcert -install && \
    mkcert -key-file /etc/apache2/ssl/cert.key -cert-file /etc/apache2/ssl/cert.pem "localhost" "127.0.0.1" "::1"

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
COPY docker/apache/ssl/localhost.pem /etc/apache2/ssl/localhost.pem
COPY docker/apache/ssl/localhost-key.pem /etc/apache2/ssl/localhost-key.pem

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Ajustar permissões do diretório de trabalho
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expor a porta HTTPS
EXPOSE 443

# Reiniciar o Apache ao iniciar o container
CMD ["apache2-foreground"]

# Pasta de trabalho
WORKDIR /var/www/html