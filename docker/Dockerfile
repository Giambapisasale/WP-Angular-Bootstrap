FROM ubuntu:trusty
MAINTAINER Francesco Borzì <borzifrancesco@gmail.com>

# Install packages
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update && \
  apt-get -y install git nano lamp-server^
RUN git clone https://github.com/Giambapisasale/WP-Angular-Bootstrap.git /var/www/html/WP-Angular-Bootstrap

RUN chmod -R 777 /var/www/WP-Angular-Bootstrap
RUN cp /var/www/WP-Angular-Bootstrap/config.php.dist /var/www/WP-Angular-Bootstrap/config.php
RUN a2enmod rewrite
