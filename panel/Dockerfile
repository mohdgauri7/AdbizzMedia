# Base PHP image
FROM php:8.1-apache

# Install additional PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copy project files to the container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Ensure proper permissions
RUN chown -R www-data:www-data /var/www/html/ && chmod -R 755 /var/www/html/

# Expose port 80
EXPOSE 80
