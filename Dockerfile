FROM php:8.1-apache

# Instala extensões necessárias
RUN apt-get update && apt-get install -y libzip-dev unzip zip \
    && docker-php-ext-install mysqli pdo pdo_mysql zip

# Ativa o módulo de reescrita
RUN a2enmod rewrite

# Copia os arquivos da aplicação
COPY . /var/www/html/

# Corrige permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Ajusta configuração do Apache
RUN echo '<Directory /var/www/html/>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/allow-override.conf \
    && a2enconf allow-override
# Copia os arquivos da aplicação
COPY . /var/www/html/

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer install --no-interaction



    