FROM php:apache

# Update and install necessary extensions
RUN apt-get update -y

# Enable Apache modules
RUN a2enmod ssl && a2enmod rewrite

# Copy PHP configuration file
COPY ./php.ini /usr/local/etc/php/

# Copy Apache configuration file
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

# Copy data directory contents to /var/www/html
COPY ./data /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

# Expose ports
EXPOSE 80
EXPOSE 443

# Create directories and install PHP dependencies
RUN mkdir -p /var/www/html/mail && \
    cd /var/www/html/mail && composer require phpmailer/phpmailer

# Create session directory and set permissions
RUN mkdir -p /var/lib/php/sessions && \
    chown -R www-data:www-data /var/lib/php/sessions && \
    chmod -R 700 /var/lib/php/sessions
