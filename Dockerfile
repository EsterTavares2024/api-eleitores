FROM php:8.1-apache

# Define o diretório de trabalho padrão dentro do container
WORKDIR /var/www/html

# Instala dependências de sistema e extensões do PHP necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev unzip zip curl git \
    && docker-php-ext-install pdo pdo_mysql mysqli zip \
    && apt-get clean

# Ativa o módulo de reescrita do Apache
RUN a2enmod rewrite

# Copia o projeto (inclua seu db.php junto ou abaixo no próximo bloco)
COPY . /var/www/html/

# Cria o arquivo de teste de conexão com o banco de dados
RUN echo "<?php \
\$host = 'db'; \
\$db   = 'db'; \
\$user = 'admin'; \
\$pass = 'admin123'; \
\$port = '3306'; \
try { \
    \$pdo = new PDO(\"mysql:host=\$host;port=\$port;dbname=\$db\", \$user, \$pass); \
    echo 'Conexão com o banco de dados estabelecida com sucesso!'; \
} catch (PDOException \$e) { \
    echo 'Erro na conexão: ' . \$e->getMessage(); \
}" > /var/www/html/dbtest.php

# Corrige permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Configura o Apache para permitir .htaccess
RUN echo '<Directory /var/www/html/>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/allow-override.conf \
    && a2enconf allow-override

# Instala o Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Instala dependências PHP com Composer
RUN composer install --no-interaction
