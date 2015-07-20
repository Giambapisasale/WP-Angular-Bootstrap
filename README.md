Portale amministrazione
====================

## Requisiti di sistema

Per installare il portale è necessario un sistema LAMP/WAMP o analogo (Apache2, PHP, MySQL).

In particolare, la versione **minima** di PHP necessaria è la **5.4**. Sono necessari inoltre le seguenti estensioni PHP:

- Mcrypt
- OpenSSL
- Mbstring
- Tokenizer
- JSON

Il portale supporta tutti i principali browser, tuttavia è consigliato utilizzare **Mozilla Firefox** oppure **Google Chrome**. È utile aggiornare il proprio browser all'ultima versione disponibile.

## Installazione tramite installer.php

Per utilizzare lo script di installazione è necessario innanzitutto copiare il file ```config.php.dist``` e rinominare la copia come ```config.php```.

Dopo di che aprire il file config.php e impostare correttamente le variabili di configurazione:

```
$db_username  = "root"; // nome utente root
```
```
$db_password  = "password"; // password dell'utente root
```

le variabili ```$db_username``` e ```$db_password``` corrispondono, come da commento, alle credenziali dell'utente root di MySQL.

Inoltre è necessario specificare il path dell'eseguibile principale di mysql:

```
$mysql        = "/usr/local/mysql/bin/mysql"; // path di mysql
```

nelle seguenti righe, che non devono assolutamente essere modificate dall'utente, lo script identifica il corretto dominio in cui sta per essere installato il portale:

```
/* non modificare queste variabili! */
$protocol = isset($_SERVER['HTTPS']) ? "https://" : "http://";
$domain = $protocol . $_SERVER['HTTP_HOST'];
/* non modificare queste variabili! */
```

NOTA TECNICA: una problematica che sorge con le righe precedenti è che lo script non è in grado di identificare il dominio se viene eseguito tramite riga di comando (con il comando ```php installer.php```), in quanto in tal modo non viene definita la variabile $_SERVER['HTTP_HOST'] che contiene una stringa rappresentante l'indirizzo del dominio.

E' necessario inoltre specificare l'indirizzo web dell'installazione del portale:

```
$new_path = $domain . ""; // path di installazione del portale
```

Per esempio se impostato come:

```
$new_path  = $domain . "/WP-Angular-Bootstrap/";
```

significa che  il portale dovrà essere installato su:

```
http://localhost/WP-Angular-Bootstrap/
```

e che la cartella del portale è attualmente situata nella directory principale del server web di apache2, per esempio:

```
/var/www/html/WP-Angular-Bootstrap
```

## Cambio di directory di installazione

Se si ha intenzione di modificare il percorso di installazione del portale **dopo** averlo già installato tramite lo script installer.php, è necessario:

- modificare il file ```portale/oauth/common.inc.php```, impostando correttamente la variabile ```$path``` con il nuovo percorso;

- eseguire le query:

```UPDATE wp_options SET option_value = 'http://localhost/nuovopath/wordpress/' where option_name='siteurl';```

```UPDATE wp_options SET option_value = 'http://localhost/nuovopath/wordpress/' where option_name='home';```

sostituendo a *nuovopath* il nuovo percorso di installazione del portale.
