# Use official PHP image with Apache
FROM php:8.2-cli

# Set working directory
WORKDIR /app

# Copy composer files
COPY composer.json composer.lock* ./

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy application files
COPY . .

# Create data directory and set permissions
RUN mkdir -p /app/data && chmod -R 777 /app/data

# Expose port (Render will set PORT env variable)
EXPOSE ${PORT:-8000}

# Start PHP built-in server
CMD php -S 0.0.0.0:${PORT:-8000}
