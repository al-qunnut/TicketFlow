# Use official PHP image
FROM php:8.2-cli

# Set working directory
WORKDIR /app

# Install system dependencies and Composer
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs || composer install --no-dev --optimize-autoloader --no-interaction

# Create data directory and set permissions
RUN mkdir -p /app/data && chmod -R 777 /app/data

# Expose port (Render will set PORT env variable)
EXPOSE 8000

# Start PHP built-in server
CMD php -S 0.0.0.0:${PORT:-8000}
