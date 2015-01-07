#!/bin/bash
#RESTORE
# Database credentials
 user="root"
 password="root"
 host="localhost"
 db_name="wordpress"
# Other options

# Set default file permissions
 umask 177
# Dump database into SQL file
  /Applications/MAMP/Library/bin/mysql --user=$user --password=$password  wordpress < /Applications/MAMP/htdocs/$db_name.sql
  
#restore
