<?php
/**
 * Il file base di configurazione di WordPress.
 *
 * Questo file definisce le seguenti configurazioni: impostazioni MySQL,
 * Prefisso Tabella, Chiavi Segrete, Lingua di WordPress e ABSPATH.
 * E' possibile trovare ultetriori informazioni visitando la pagina: del
 * Codex {@link http://codex.wordpress.org/Editing_wp-config.php
 * Editing wp-config.php}. E' possibile ottenere le impostazioni per
 * MySQL dal proprio fornitore di hosting.
 *
 * Questo file viene utilizzato, durante l'installazione, dallo script
 * di creazione di wp-config.php. Non è necessario utilizzarlo solo via
 * web,è anche possibile copiare questo file in "wp-config.php" e
 * rimepire i valori corretti.
 *
 * @package WordPress
 */

// ** Impostazioni MySQL - E? possibile ottenere questoe informazioni
// ** dal proprio fornitore di hosting ** //
/** Il nome del database di WordPress */
define('DB_NAME', 'wordpress');

/** Nome utente del database MySQL */
define('DB_USER', 'root');

/** Password del database MySQL */
define('DB_PASSWORD', 'root');

/** Hostname MySQL  */
define('DB_HOST', 'localhost');

/** Charset del Database da utilizare nella creazione delle tabelle. */
define('DB_CHARSET', 'utf8');

/** Il tipo di Collazione del Database. Da non modificare se non si ha
idea di cosa sia. */
define('DB_COLLATE', '');

/**#@+
 * Chiavi Univoche di Autenticazione e di Salatura.
 *
 * Modificarle con frasi univoche differenti!
 * E' possibile generare tali chiavi utilizzando {@link https://api.wordpress.org/secret-key/1.1/salt/ servizio di chiavi-segrete di WordPress.org}
 * E' possibile cambiare queste chiavi in qualsiasi momento, per invalidare tuttii cookie esistenti. Ciò forzerà tutti gli utenti ad effettuare nuovamente il login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'H 8x{;Sk~<m}F(G*aI6o6oJ`HWJWKe|`AP=Y{|@6|ItK-FT{c-C{a2`%8<}:G6yJ');
define('SECURE_AUTH_KEY',  '+y:-[{{pCN+dA43=|oFTB(`!snHYWWXnL0U%h$(v+|!@2@aj8WYN@ujOOiW>gntU');
define('LOGGED_IN_KEY',    'H!*4,C=uq[I@qxw-h[qysfjk@H~}uh%C.bN- LoULlRaBjW=!|oN6o|Um[G@YNAX');
define('NONCE_KEY',        'X&BBa3Z]@s6NKE1gCb)#nmJYAO1dW.S3jdU-MmPP_;HE{/Tn 9<9iVi4]DVA9yy>');
define('AUTH_SALT',        '^m6M1;|8+VX|^*Et+kDp0+T,}lpLoj&|hk%Vya6O$O[Uh,|pr)[>p^e4H 0(X_O@');
define('SECURE_AUTH_SALT', 't)$u=}Gof]si.8pOEG7W9G}sW-+~c+sSy|j>Snh%>zwn-1dYQsO2kO91bS<[DJkK');
define('LOGGED_IN_SALT',   'x-8UI,j8_44iuRg|N1uXR3@_QQ$J8KN=Q.Xp/4;LHs`mF-1;xqLMYVly?>J-FNF*');
define('NONCE_SALT',       'BJ! e><Jr[8!t5ns6wt:9>:Pe2H$(!mJI$(2?1zBKEc25{MoF<S;L1,`+i`*ZG*K');

/**#@-*/

/**
 * Prefisso Tabella del Database WordPress .
 *
 * E' possibile avere installazioni multiple su di un unico database if you give each a unique
 * fornendo a ciascuna installazione un prefisso univoco.
 * Solo numeri, lettere e sottolineatura!
 */
$table_prefix  = 'wp_';

/**
 * Per gli sviluppatori: modalità di debug di WordPress.
 *
 * Modificare questa voce a TRUE per abilitare la visualizzazione degli avvisi
 * durante lo sviluppo.
 * E' fortemente raccomandato agli svilupaptori di temi e plugin di utilizare
 * WP_DEBUG all'interno dei loro ambienti di sviluppo.
 */
define('WP_DEBUG', false);

/* Finito, interrompere le modifiche! Buon blogging. */

/** Path assoluto alla directory di WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Imposta lle variabili di WordPress ed include i file. */
require_once(ABSPATH . 'wp-settings.php');
