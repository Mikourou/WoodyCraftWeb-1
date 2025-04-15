# Utilisation d'une image de base PHP
FROM php:8.1-fpm

# Définition du répertoire de travail
WORKDIR /var/www/html

# Installation des dépendances nécessaires
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Installer les extensions PHP requises pour Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copie des fichiers du projet dans le conteneur
COPY . .

# Installation des dépendances PHP
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Définition des permissions pour les fichiers de stockage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Exposition du port sur lequel l'application va écouter
EXPOSE 9000

# Commande de démarrage
CMD ["php-fpm"]