FROM php:8.2-apache

# Instalamos la extensión de base de datos
RUN docker-php-ext-install pdo_mysql

# Render inyecta la variable PORT. Configuramos Apache para que escuche en ese puerto
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Copiamos nuestro código fuente a la carpeta pública de Apache
COPY src/ /var/www/html/
