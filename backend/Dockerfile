# Backend PHP pour Render - Support MySQL et PostgreSQL
FROM php:8.2-apache

# Installation des dépendances système pour PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Installation des extensions PHP nécessaires (MySQL + PostgreSQL)
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql mysqli

# Activation du module rewrite pour Apache
RUN a2enmod rewrite

# Copie du code source du backend uniquement
COPY ./backend /var/www/html/

# Configuration des permissions
RUN chown -R www-data:www-data /var/www/html

# Exposition du port 80
EXPOSE 80

# Démarrage d'Apache
CMD ["apache2-foreground"]
