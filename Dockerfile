FROM php:8.3-cli

# Instalar dependencias del sistema y extensiones de PHP en un solo paso
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libpng-dev libxml2-dev libzip-dev libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring xml gd zip bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copiar proyecto
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Instalar dependencias Node y compilar assets
RUN npm ci && npm run build

# Configuración PHP para uploads
COPY uploads.ini /usr/local/etc/php/conf.d/uploads.ini

# Permisos
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8000

RUN rm -f .env 

# Limpiamos variables de entorno y ejecutamos
CMD php artisan storage:link && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8000}