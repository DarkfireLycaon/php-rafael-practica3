FROM php:8.2-apache

# 1. Instalamos las librerías de PostgreSQL y activamos los drivers PDO para Postgres
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# 2. Configuramos Apache para que escuche en el puerto dinámico de Render ($PORT)
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# 3. Copiamos nuestro código fuente a la carpeta pública de Apache
COPY src/ /var/www/html/
