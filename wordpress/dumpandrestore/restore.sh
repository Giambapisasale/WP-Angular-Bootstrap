#!/bin/bash

# utente root
user="root"

# password utente root
password="root"

# indirizzo host
host="localhost"

# indirizzo istanza wordpress
url="http://localhost/WP-Angular-Bootstrap/wordpress/"
home="http://localhost/WP-Angular-Bootstrap/wordpress/"

# path di mysql, esempio: /path/to/mysql
mysql="mysql"

# crea database se non esiste
$mysql --user=$user --password=$password --execute="CREATE DATABASE IF NOT EXISTS wordpress;"

# crea utente "portale" se non esiste, con password "fragole", e assegna tutti i privilegi per il database wordpress
$mysql --user=$user --password=$password --execute="GRANT ALL PRIVILEGES ON wordpress.* To 'portale'@'localhost' IDENTIFIED BY 'fragole';"

# importa dump
$mysql --user=$user --password=$password  wordpress < wordpress.sql

# configura url wordpress
$mysql --user=$user --password=$password  wordpress --execute="UPDATE wp_options SET option_value = '$url' where option_name='siteurl';"

# configura home wordpress
$mysql --user=$user --password=$password  wordpress --execute="UPDATE wp_options SET option_value = '$home' where option_name='home';"
