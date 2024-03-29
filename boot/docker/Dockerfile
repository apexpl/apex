
FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libfreetype6-dev \
    locales \
    libzip-dev \
    zip \ 
    vim \
    nano \
    unzip \
    git \
    subversion \
    curl \
    default-mysql-client \
    libpq-dev \
    postgresql-client \
    wget \
    libgmp-dev \
    gnupg2 \
    libgpgme11-dev \
    ansible

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install gd sockets pdo pdo_mysql pdo_pgsql zip gmp bcmath

# Install php-redis
RUN pecl install -o -f redis && \ 
    rm -rf /tmp/pear && \
    docker-php-ext-enable redis

# Install php gnupg extension
RUN wget https://pecl.php.net/get/gnupg -O /tmp/gnupg.tgz \
    && tar xf /tmp/gnupg.tgz -C /tmp

RUN cd /tmp/gnupg-* \
    && phpize \
    && ./configure \
    && make \
    && make install

# Install composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Add user
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Set workdir
WORKDIR /var/www

# Copy existing application directory contents
COPY apex /usr/bin/
COPY . /var/www
COPY ./boot/docker/user /home/www
COPY --chown=www:www . /var/www
COPY --chown=www:www ./boot/docker/user /home/www

# Change current user to www
USER www

# Initialize gpg
RUN gpg --list-keys

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD bash -c "composer update -n --prefer-dist && php-fpm"
#CMD ["php-fpm"]


