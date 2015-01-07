#!/bin/bash
# Database credentials
 user="root"
 password="root"
 host="localhost"
 db_name="wordpress"
 path="/Applications/MAMP/Library/bin"
# Other options

# Set default file permissions
 umask 177
# Dump database into SQL file
  $path/mysqldump --user=$user --password=$password --host=$host $db_name > $db_name.sql
