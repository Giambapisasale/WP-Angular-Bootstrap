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
define('AUTH_KEY',         '@*-%Q-C`9>QTQ+G(-.&O<CqN3E-&^%Q:Oic^huWJ6ZV3L|4a:+-F1:&KLvH]7r3S');
define('SECURE_AUTH_KEY',  'X(s%ZjW+vGj|JG3!hJVbIlM5tr9F+aI}3Af@Fw#R,O>tql(nS(VjnD1~giN jBH=');
define('LOGGED_IN_KEY',    'g^]`fB!wZc>qnwQwMKB,-^&7zv-ojOFH8Erd$0f(?+#]D4bL`Rg(5})03V1Uo7(q');
define('NONCE_KEY',        '+ru3a)jN:XO6|Ti[0cf++P 8)lyzi_-xVm>v67>ngA+4|7~W;4iFU~*m`cLd;&d-');
define('AUTH_SALT',        '@1mW@nz}q+o2Vc)NU//@!;kRy|ipJ19e+emR[howE3n%~o. k~>ga+~;oIV(,U-A');
define('SECURE_AUTH_SALT', 'GmD*qMd9BWrs0U++~VY_.b6Nm_C0fX:xM$43lDVQZDArWg4[(.h@321VN|umg1}y');
define('LOGGED_IN_SALT',   'cacD.n&$OgSt#&f V;g^)A!Posr(L)P|00w6xr0ou-d-Ehdrf8_<9r5_0h/>*{z#');
define('NONCE_SALT',       'W[?`};U#UH|72S1]M%+z6u#j-:vM@ClLI?C}y4x%h;)LS/s3Ph1F]1822vpW[]3A');

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
