<?php

$db_username  = "root"; // necessario per creare utente "portale"
$db_password  = "";
$db_name      = "portale";

$connection = mysqli_connect("localhost", $db_username, $db_password);

if (mysqli_connect_errno($connection))
  echo "Errore nella connessione a MySQL: " . mysqli_connect_error();
else
  mysqli_query($connection, "set names utf8");

$query = sprintf("CREATE DATABASE IF NOT EXISTS %s", $db_name);
execute($query);

function execute($query)
{
  global $connection;

  $result = mysqli_query($connection, $query);

  if (!$result)
    die("Errore nella query: " . $query);
}

?>
