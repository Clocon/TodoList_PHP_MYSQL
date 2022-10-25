<?php

include ('includes/conexion.php');
require_once 'includes/conexion.php';

try { 
  $conect = new PDO($sql, $user, $password);
} catch (PDOException $error) {
  echo 'Connection error: ' . $error->getMessage();
}

$date=new DateTime();
$dateCreated = $date->format('Y/m/d H:i:s');

function checkID($id, $conect){
  $a= $conect->query("SELECT * FROM tareas WHERE ID=".$id)->fetchAll();
  if(!$a){
    http_response_code(404);
    echo "El ID al que intentas acceder no existe.";
    die;
  }
}

function addTarea($title, $description, $dateCreated, $conect){
  $add = $conect-> prepare ( 'INSERT INTO tareas (Título, Descripción, Fecha_Creación) VALUES (:title, :description, :dateCreated)' );
  try{
    $add-> bindParam ( 'title', $title );
    $add-> bindParam ( 'description', $description ) ;
    $add-> bindParam ( 'dateCreated', $dateCreated ) ;

    if ($add->execute()) {
      print "Nueva entrada añadida satisfactoriamente.";
    }
  }catch(PDOException $error){
    echo "No se pudo crear el registro". $error->getMessage();
  }
}

function editTarea($id, $description, $category, $conect){
  checkID($id, $conect);
  $edit = $conect->prepare ("UPDATE tareas SET Descripción=:description,Categoría=:category WHERE ID = :id ");
  try{ 
    $edit-> bindValue ( ':description', $description , PDO::PARAM_STR);
    $edit-> bindValue ( ':category', $category, PDO::PARAM_STR ) ;
    $edit-> bindValue ( ':id', $id , PDO::PARAM_INT) ;

    if ($edit->execute()) {
      echo "Actualización realizada con éxisto.";
    } 
  }catch(PDOException $error){
    echo "No se pudo editar.". $error->getMessage();
  }
}

function deleteTarea($id, $conect){
  checkID($id, $conect);
  $delete = $conect->prepare("DELETE FROM tareas WHERE ID=:id");
  try{
    $delete -> bindParam(':id', $id , PDO::PARAM_INT);
    if($delete->execute()){
      print "La tarea fue eliminada con éxito, ya quedan menos!";
    }
  }catch(PDOException $error){
    echo "La tarea que intentas borrar no existe, elige un ID válido.".$error->getMessage();
  }
}

function consultTarea($conect){
  $sql = 'SELECT * FROM tareas ORDER BY ID';
  return $conect->query($sql)->fetchAll();
}

function IDSelector($conect){
  $sql = 'SELECT * FROM tareas ORDER BY ID';
  foreach ($conect->query($sql) as $row) {
  echo '<option>'.$row['ID'].'</option>';
  }
}