FROM php:7.3.2-fpm

RUN apt-get update && apt-get install -y \
        libzip-dev \
        zip \
        libpq-dev \
	&& docker-php-ext-configure zip --with-libzip \
	&& docker-php-ext-install zip \
	&& docker-php-ext-install pdo pdo_mysql mysqli \
	&& docker-php-ext-install mbstring tokenizer \
	&& docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
	&& docker-php-ext-install pgsql pdo_pgsql

#Memcached
#RUN apt-get update && apt-get install -y \
#    libmemcached-dev \
#    curl

# Install Memcached for php 7
#RUN curl -L -o /tmp/memcached.tar.gz "https://github.com/php-memcached-dev/php-memcached/archive/php7.tar.gz" \
#    && mkdir -p /usr/src/php/ext/memcached \
#    && tar -C /usr/src/php/ext/memcached -zxvf /tmp/memcached.tar.gz --strip 1 \
#    && docker-php-ext-configure memcached \
#    && docker-php-ext-install memcached \
#    && rm /tmp/memcached.tar.gz

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node | Npm
RUN apt-get update -yq \
    && apt-get install curl gnupg -yq \
    && curl -sL https://deb.nodesource.com/setup_14.x | bash \
    && apt-get install nodejs -yq

WORKDIR /var/www/tion

# Install latest chrome dev package.
# Note: this installs the necessary libs to make the bundled version of Chromium that Pupppeteer
# installs, work.
RUN apt-get update \
    && apt-get install -y wget gnupg \
    && wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | apt-key add - \
    && sh -c 'echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google.list' \
    && apt-get update \
    && apt-get install -y google-chrome-stable fonts-ipafont-gothic fonts-wqy-zenhei fonts-thai-tlwg fonts-kacst fonts-freefont-ttf libxss1 libc6 libcairo2 libcups2 libdbus-1-3 libexpat1 libfontconfig1 libgcc1 libgconf-2-4 libgtk-3-0 libnspr4 libx11-6 libx11-xcb1 libxcb1 libxtst6 \
      --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*

#RUN npm i puppeteer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www
# Copy existing application directory contents
COPY . /var/www
# Copy existing application directory permissions
COPY --chown=www:www . /var/www
# Change current user to www
USER www

