<?php
$server = 'localhost';
$user = 'Luis';
$DB = 'todolist';
$password = 'prueba123';
$sql = "mysql:host=$server;dbname=$DB;";
$dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];


/* if (!$conect) { 
  die('<strong>No pudo conectarse:</strong> ' . mysql_error()); 
}else{ 

  echo 'Conectado  satisfactoriamente al servidor <br />';
}
  */
?>