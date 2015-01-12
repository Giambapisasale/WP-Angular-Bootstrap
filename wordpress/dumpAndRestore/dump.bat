::!/bin/bash

:: utente root
set user="portale"

:: password utente root
set password="fragole"

:: indirizzo host
set host="localhost"

:: nome del database

set database="portale"

:: path di mysqldump.exe, esempio: /path/to/mysqldump.exe
set mysqldump="C:\wamp\bin\mysql\mysql5.5.24\bin\mysqldump"

%mysqldump% -u%user% -p%password% -h%host% %database% > %database%.sql
