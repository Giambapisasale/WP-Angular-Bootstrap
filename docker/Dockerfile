FROM ubuntu:trusty
MAINTAINER Francesco Borzì <borzifrancesco@gmail.com>

# Install packages
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update && \
  apt-get -y install git nano lamp-server^
RUN git clone https://github.com/Giambapisasale/WP-Angular-Bootstrap.git /var/www/html/WP-Angular-Bootstrap

RUN chmod -R 777 /var/www/html/WP-Angular-Bootstrap/
RUN cp /var/www/html/WP-Angular-Bootstrap/config.php.dist /var/www/html/WP-Angular-Bootstrap/config.php
RUN rm /etc/apache2/apache2.conf
RUN cp /var/www/html/WP-Angular-Bootstrap/docker/apache2.conf /etc/apache2/apache2.conf
RUN a2enmod rewrite
RUN service mysql start
RUN service apache2 start
