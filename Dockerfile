FROM php:8.3-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libpng-dev libxml2-dev libzip-dev libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring xml gd zip bcmath \
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

# Permisos
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD export APP_URL=$(echo "$APP_URL" | tr -d '\r') && \
    export ASSET_URL=$(echo "$ASSET_URL" | tr -d '\r') && \
    export GOOGLE_REDIRECT_URI=$(echo "$GOOGLE_REDIRECT_URI" | tr -d '\r') && \
    php artisan storage:link && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
