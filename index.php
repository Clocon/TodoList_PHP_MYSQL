

<?php
/////////////////////////////////// Conexión
include ('includes/conexion.php');
require_once 'includes/conexion.php';

try { 
  $conect = new PDO($sql, $user, $password);
  echo '<h1>Bienvenid@ '.$user.' a la base de datos '.$DB .'.</h1>' ;
} catch (PDOException $error) {
  echo 'Connection error: ' . $error->getMessage();
}

//Daatos 
$date=new DateTime();
$id ;
$title = '' ;
$description = '' ;
$dateCreated = $date->format('Y/m/d H:i:s');
$category='';


///////////////////////////////////Función para añadir
function addTarea($title, $description, $dateCreated, $conect){
  $add = $conect-> prepare ( 'INSERT INTO tareas (Título, Descripción, Fecha_Creación) VALUES (:title, :description, :dateCreated)' );
  $title=filter_input(INPUT_POST,'titulo-add');
  $description=filter_input(INPUT_POST,'descricion-add');
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


///////////////////////////////////Función para Editar
function editTarea($description, $category,$id, $conect){
  $edit = $conect->prepare ("UPDATE tareas SET Descripción=:description,Categoría=:category WHERE ID = :id ");
  $description=filter_input(INPUT_POST,'descricion-edit');
  $category=filter_input(INPUT_POST,'categoria-edit');
  $id=filter_input(INPUT_POST,'llave-edit');
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

///////////////////////////////////Función para Eleminar
function deleteTarea($id, $conect){
  $delete = $conect->prepare("DELETE FROM tareas WHERE ID=:id");
  $id=filter_input(INPUT_POST,'llave-delete');
  try{
    $delete -> bindParam(':id', $id , PDO::PARAM_INT);
    if($delete->execute()){
      print "La tarea fue eliminada con éxito, ya quedan menos!";
    }
  }catch(PDOException $error){
    echo "La tarea que intentas borrar no existe, elige un ID válido.".$error->getMessage();
  }
  
}

///////////////////////////////////Funcion para consultar tareas
function consultTarea($conect){
  $sql = 'SELECT * FROM tareas ORDER BY ID';
  foreach ($conect->query($sql) as $row) {
    echo "<tr>";
    echo '<td>'.$row['ID'].'</td>';
    echo '<td>'.$row['Título'].'</td>';
    echo '<td>'.$row['Categoría'].'</td>';
    echo '<td>'.$row['Descripción'].'</td>';
    echo '<td>'.$row['Fecha_Creación'].'</td>';
    echo '<td>'.$row['Fecha_Actualización'].'</td>';
    echo "</tr>";    
  }
}

function IDSelector($conect){
  $sql = 'SELECT * FROM tareas ORDER BY ID';
  foreach ($conect->query($sql) as $row) {
  echo '<option>'.$row['ID'].'</option>';
  }
}
  
///////////////////////////////////Llamada funciones.
//addTarea($title, $description, $dateCreated,$conect);
//editTarea($description, $category, $id, $conect);
//deleteTarea($id, $conect);

if (!NULL== filter_input(INPUT_POST,'añadir')){
  echo "SALU2";
  addTarea($title, $description, $dateCreated, $conect);
  }else{
    echo "Rellena todos los campos";
  }
?>

<html>
  <header> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </header>
  <body>
    <div>
      <div>
        <h3>Añade una tarea a tu lista</h3>
        <form  class="form-group col-md-6 d-flex flex-row" action="index.php" method="POST">
          <input type="text" class="form-control" name="titulo-add" placeholder="¿Que tarea tienes que realizar?">
          <input type="text" class="form-control" name="descripcion-add" placeholder="Dame una descripción breve de la tarea.">
          <button type="submit" class="btn btn-primary" name="añadir">Añadir</button>
        </form>
      </div>
      <div>
        <h3>Quieres modificar alguna de tus tareas?</h3>
        <form class="form-group  d-flex   flex-row " action="index.php" method="POST">
          <input type="text" class="form-control" name="descricion-edit" placeholder="¿Quieres cambiar la descripción de la tarea?">
          <input type="text" class="form-control" name="categoria-edit" placeholder="¿Quieres meter esta tarea en alguna categoria específica?">
          <select id="inputState" name="llave-edit" class="form-control">
            <?php IDSelector($conect); ?>
          </select>  
          <button type="submit" class="btn btn-primary">Modificar</button>
        </form>
      </div>
      <div>
        <table class="table">
          <tr>
            <td>ID</td>
            <td>Título</td>
            <td>Categoría</td>
            <td>Descripción</td>
            <td>Fecha Creación</td>
            <td>Fecha Actualización</td>
          </tr>
          <?php 
          consultTarea($conect); ?>
        </table>
      </div>  
      <div>
        <h3>Qué tarea has terminado ya?</h3>
        <form class="form-group  col-md-2 d-flex" action="index.php" method="POST">
          <select id="inputState" name="llave-delete" class="form-control ">
            <?php IDSelector($conect); ?>
          </select>  
          <button type="submit" class="btn btn-primary">Modificar</button>
        </form>
      </div>
    </div>
  </body>
  <footer></footer>
</html>