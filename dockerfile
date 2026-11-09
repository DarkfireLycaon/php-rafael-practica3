FROM php:8.2-apache

# 1. Instalar dependencias y extensiones de PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# 2. Configurar Apache para usar el puerto dinámico de Render y definir ServerName
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# 3. Copiar el código fuente
COPY src/ /var/www/html/
RUN chown -R www-data:www-data /var/www/html
