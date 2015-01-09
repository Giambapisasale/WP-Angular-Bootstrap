Istruzioni configurazione restore/dump database
====================

- All'interno cartella **/wordpress/dumpAndRestore/** copiare i file **dump.sh.dist** e **restore.sh.dist** rinominandoli rispettivamente **dump.sh** e **restore.sh**

- Aprire i file restore.sh e dump.sh e modificare opportunamente le variabili di configurazione. I commenti presenti all'interno dei file spiegano il significato di ogni variabile.

- Assegnare ai file **restore.sh** e **dump.sh** eventuali permessi di esecuzione.

- Adesso è possibile eseguire gli script **restore.sh** e **dump.sh** per importare/esportare il database di wordpress. Il dump che verrà generato è **/wordpress/dumpAndRestore/wordpress.sql**

- Eventuali modifiche alla struttura o ai contenuti del database di wordpress devono essere esportate ed è necessario eseguire il commit del dump **wordpress.sql**

- Le credenziali di accesso a wordpress sono username **admin** e password **testadmin**

- Per utilizzare il plugin wp-api è necessario abilitare i permalink, se i permalink non sono abilitati potrebbe essere necessario [modificare la configurazione di apache](http://stackoverflow.com/questions/18740419/how-to-set-allowoverride-all)

- Se il percorso dove risiede wordpress è diverso da http://localhost**/WP-Angular-Bootstrap/wordpress/**, modificare il file .htaccess della cartella wordpress sostituendo a **/WP-Angular-Bootstrap/wordpress/** il percorso dell'istanza di wordpress (ad esempio se http://localhost/sito/wordpress/ sostituire con **/sito/wordpress**)
