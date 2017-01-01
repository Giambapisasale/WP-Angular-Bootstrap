::!/bin/bash

::utente root
set user="portale"

:: password utente root
set password="fragole"

:: indirizzo host
set host="localhost"

:: nome del database

set database="portale"
:: indirizzo istanza wordpress
set url="http://localhost/WP-Angular-Bootstrap/wordpress/"
set home="http://localhost/WP-Angular-Bootstrap/wordpress/"

:: path di mysql, esempio: /path/to/mysql
set mysql="C:\wamp\bin\mysql\mysql5.5.24\bin\mysql.exe"


:: importa dump
%mysql% -u%user% -p%password%  %database% < wordpress.sql

:: configura url di wordpress
%mysql% -u%user% -p%password%  %database% --execute="UPDATE wp_options SET option_value = '%url%' where option_name='siteurl';"

:: configura home di wordpress
%mysql% -u%user% -p%password%  %database% --execute="UPDATE wp_options SET option_value = '%home%' where option_name='home';"
