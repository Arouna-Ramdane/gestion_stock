#gestion_stock
FROM php:8.4

WORKDIR /project

COPY gestion_stock/ .


RUN apt update && apt install -y \
    libfreetype-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libpq-dev \
    texlive \
    texlive-latex-extra \
    texlive-fonts-recommended \
    texlive-lang-french \
    zip unzip curl gnupg \
 && docker-php-ext-install bcmath pgsql pdo_pgsql pcntl \
 && apt -y autoremove \
 && apt -y clean


RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
 && php composer-setup.php \
 && php -r "unlink('composer-setup.php');" \
 && mv composer.phar /usr/local/bin/composer 


RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt install -y nodejs


RUN npm install \
 && npm install -D tailwindcss @tailwindcss/vite \
 && npm install -D daisyui@latest

EXPOSE 9999

ENTRYPOINT ["composer", "run", "dev"]

