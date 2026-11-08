FROM dunglas/frankenphp:php8.4-alpine

# Set environment variables
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_MEMORY_LIMIT=-1 \
    SERVER_NAME=":8080"

# Install system dependencies (git, unzip, curl, bash, nodejs, npm)
RUN apk add --no-cache \
    git \
    unzip \
    curl \
    bash \
    nodejs \
    npm

# Install PDO, PostgreSQL and required extensions
RUN install-php-extensions \
    pdo_pgsql \
    pgsql \
    pcntl \
    gd \
    intl \
    zip \
    bcmath \
    opcache

# Increase PHP upload limits & configure OPcache
RUN echo 'upload_max_filesize = 50M' > /usr/local/etc/php/conf.d/uploads.ini && \
    echo 'post_max_size = 50M' >> /usr/local/etc/php/conf.d/uploads.ini && \
    echo 'memory_limit = 512M' >> /usr/local/etc/php/conf.d/uploads.ini && \
    echo 'opcache.enable = 1' > /usr/local/etc/php/conf.d/opcache.ini && \
    echo 'opcache.enable_cli = 1' >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo 'opcache.memory_consumption = 256' >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo 'opcache.interned_strings_buffer = 16' >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo 'opcache.max_accelerated_files = 20000' >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo 'opcache.validate_timestamps = 0' >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo 'opcache.save_comments = 1' >> /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /app

# Copy Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Composer dependencies (cached layer)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --ignore-platform-reqs --no-progress

# Install NPM dependencies (cached layer)
COPY package.json package-lock.json* ./
RUN npm install

# Copy application source
COPY . /app/

# Finish Composer dump-autoload & package discovery
RUN composer dump-autoload --optimize --no-dev && \
    php artisan package:discover --ansi

# Build frontend assets with Vite
RUN npm run build

# Set permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache || true

# Copy Caddyfile and entrypoint script
COPY Caddyfile /app/Caddyfile
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN dos2unix /usr/local/bin/docker-entrypoint.sh 2>/dev/null || true && \
    chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 8080 8000
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
