<?php

/* Configurazione Utente */

require_once("config.php");


/* Configurazione Sviluppatore */

$db_name      = "portale";
$old_path     = "http://localhost/WP-Angular-Bootstrap/";
$sql_dump     = "wordpress/dumpAndRestore/wordpress.sql";

$common_inc       = "portale/oauth/common.inc.php.rename_me";
$common_inc_dest  = "portale/oauth/common.inc.php";


/* Variabili */

$new_path_wordpress = $new_path . "wordpress/";
$old_path_wordpress = $old_path . "wordpress/";


/* Funzioni */

function execute($query)
{
  global $connection;

  $result = mysqli_query($connection, $query);

  if (!$result)
    die("Errore nella query: " . $query);
}


/* Installazione Database */

$connection = mysqli_connect("localhost", $db_username, $db_password);

if (mysqli_connect_errno($connection))
  die("Errore nella connessione a MySQL: " . mysqli_connect_error());
else
  mysqli_query($connection, "set names utf8");

$query = sprintf("CREATE DATABASE IF NOT EXISTS %s", $db_name);
execute($query);

$query = sprintf("GRANT ALL PRIVILEGES ON %s.* To 'portale'@'localhost' IDENTIFIED BY 'fragole'", $db_name);
execute($query);

$new_dump = file_get_contents($sql_dump);
$new_dump = str_replace($old_path_wordpress, $new_path_wordpress, $new_dump);
file_put_contents('new_dump.sql', $new_dump);

$import = sprintf("%s --user=portale --password=fragole --host=localhost %s < '%s/new_dump.sql'",
                  $mysql,
                  $db_name,
                  getcwd());

echo exec($import, $output, $retvar);

if ($retvar == 0)
{
  $file = $new_path . "wordpress/wp-json/";
  $file_headers = @get_headers($file);
  if($file_headers[0] == 'HTTP/1.1 404 Not Found')
  {
    die( "Il database e' stato installato, tuttavia sembra che i permalink non siano abilitati. Abilitare i permalink e riavviare lo script di installazione.<br>\n<br>\n Per abilitare i permalink è necessario modificare il file di configurazione di Apache2 /etc/apache2/apache2.conf sostituire 'AllowOverride None' con 'AllowOverride All' per la directory desiderata (o per tutte le directory), dopo di che riavviare il servizio apache2.<br>\n<br>\n" );
  }
  else
  {
    echo "Database installato con successo!<br>\n";
  }
}
else
  die("Errore nell'installazione del database! Assicurarsi di aver impostato correttamente i permessi della cartella del progetto e le variabili di configurazione utente.<br>\n");


/* Installazione Oauth */

$oauth_path = substr($new_path, strlen($domain), $new_path.length-1);

$new_common_inc = file_get_contents($common_inc);

if ($new_common_inc == false)
{
  die( "Errore! Assicurarsi di aver impostato correttamente i permessi della cartella del progetto.<br>\n" );
}

$new_common_inc = str_replace("\$path = \"\";", "\$path = \"" . $oauth_path . "\";", $new_common_inc);
file_put_contents($common_inc_dest, $new_common_inc);

echo "Oauth installato con successo!<br>\n";

?>
