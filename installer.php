<?php

/* Configurazione Utente */

$db_username  = "root"; // nome utente root, necessario per creare utente "portale"
$db_password  = "";     // password dell'utente root

$mysql        = "/usr/bin/mysql"; // path di mysql

$new_path     = ""; // path di installazione del portale


/* Configurazione Sviluppatore */

$db_name      = "portale";
$old_path     = "http://localhost/WP-Angular-Bootstrap/wordpress/";
$sql_dump     = "wordpress/dumpAndRestore/wordpress.sql";


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
$new_dump = str_replace($old_path, $new_path, $new_dump);
file_put_contents('new_dump.sql', $new_dump);

$import = sprintf("%s --user=portale --password=fragole --host=localhost %s < '%s/new_dump.sql'",
                  $mysql,
                  $db_name,
                  getcwd());

echo exec($import, $output, $retvar);

if ($retvar == 0)
  echo "Database installato con successo!<br>\n";
else
  die("Errore nell'installazione del database<br>\n");

?>
