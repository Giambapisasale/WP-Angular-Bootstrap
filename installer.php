<?php

/* Funzioni */

function execute($query)
{
  global $connection;

  $result = mysqli_query($connection, $query);

  if (!$result)
    die("Errore nella query: " . $query);
}

/* Configurazione */

$db_username  = "root"; // necessario per creare utente "portale"
$db_password  = "";
$db_name      = "portale";
$mysql        = "/usr/local/mysql/bin/mysql";

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

$import = sprintf("%s --user=portale --password=fragole --host=localhost %s < '%s/wordpress/dumpAndRestore/wordpress.sql'",
                  $mysql,
                  $db_name,
                  getcwd());

echo exec($import, $output, $retvar);

if ($retvar == 0)
  echo "Database installato con successo!<br>\n";
else
  die("Errore nell'installazione del database<br>\n");

?>
