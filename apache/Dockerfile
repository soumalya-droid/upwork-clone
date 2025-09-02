# Start from the official PHP Apache image
FROM php:8.0-apache

# Install the pdo_mysql extension for database connectivity
RUN docker-php-ext-install pdo_mysql

# Enable Apache's rewrite module for .htaccess URL rewriting to work
RUN a2enmod rewrite
