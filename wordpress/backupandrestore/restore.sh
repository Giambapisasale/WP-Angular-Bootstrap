#!/bin/bash
#RESTORE
# Database credentials
 user="root"
 password="root"
 host="localhost"
 db_name="wordpress"
 url="http://localhost:8888/wordpress"
 home="http://localhost:8888/wordpress"
 path="/Applications/MAMP/Library/bin"
# Other options

# Set default file permissions
 umask 177
# Dump database into SQL file
  $path/mysql --user=$user --password=$password  wordpress < /Applications/MAMP/htdocs/$db_name.sql
 
 $path/mysql --user=$user --password=$password  wordpress --execute="UPDATE wp_options SET option_value = '$url' where option_name='siteurl'"
  $path/mysql --user=$user --password=$password  wordpress --execute="UPDATE wp_options SET option_value = '$home' where option_name='home'"
