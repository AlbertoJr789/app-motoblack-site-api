FROM php:8.3-fpm

WORKDIR /var/www/motoblack

# Install dependencies
RUN apt-get update
RUN apt-get install -y \
    nano \
    git \
    curl \
    libonig-dev \
    nodejs npm \
    wkhtmltopdf

RUN npm install vite

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring  
# RUN docker-php-ext-configure gd --with-external-gd
# RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Expose port 9000 and start php-fpm server
EXPOSE 9000
