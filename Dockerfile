FROM php:8.3-apache AS base

COPY --from=composer:2.2.7 /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
    apt-get install -y \
    curl unzip \
    && apt-get clean

# copy and confirgure Apache Virtual Hosts
COPY ./docker/apache/default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

WORKDIR /var/www/html
# set www-data user  home directory
# the user "www-data" is used when running the image, and therefore should own the workdir
RUN usermod -m -d /home/www-data www-data && \
    mkdir -p /var/www/html && \
    chown -R www-data:www-data /home/www-data /var/www/html

USER www-data

##############################################

FROM base AS development

USER root

# allow overwriting UID and GID o the user "www-data" to help solve issues with permissions in mounted volumes
# if the GID is already in use, assign GID 33 instead (33 is the standard uid/gid for "www-data" in Debian)
ARG www_data_uid
ARG www_data_gid

RUN deluser www-data && \
    (addgroup --gid $www_data_gid www-data || addgroup --gid 33 www-data) && \
    adduser --system --home /home/www-data --uid $www_data_uid --disabled-password --group www-data;

# as the UID and GID might have changed, change the ownership of the home directory workdir again
RUN chown -R www-data:www-data /home/www-data /var/www/html

USER www-data
