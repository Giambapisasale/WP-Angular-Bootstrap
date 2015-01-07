#!/bin/bash
# Database credentials
 user="root"
 password="root"
 host="localhost"
 db_name="wordpress"
# Other options

# Set default file permissions
 umask 177
# Dump database into SQL file
  /Applications/MAMP/Library/bin/mysqldump --user=$user --password=$password --host=$host $db_name > $db_name.sql
