Istruzioni configurazione restore/dump database
====================

Per poter rimanere allineati su una stessa versione del portale, è necessario che impostiamo tutti lo stesso account, in modo tale che in ogni istante possiamo esportare ed importare il database della nostra versione di wordpress installata ed eseguire il commit su github. 

Ciò viene fatto automaticamente dallo script restore.sh.

Sono stati creati due file bash per il backup e il restore del database, che vanno inseriti nella cartella wordpress.

Su restore.sh e dump.sh sono presenti le seguenti variabili:

- **user**: corrisponde alla user del nostro database

- **password**: password del database

- **host**: di default localhost

- **mysql** e **mysqldump**: indicano i path dove risiedono mysql e mysqldump
