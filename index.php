

<?php
/////////////////////////////////// Conexión
include ('includes/conexion.php');
require_once 'includes/conexion.php';

try { 
  $conect = new PDO($sql, $user, $password);
  //$conect = @mysqli_connect($server,$user,$password,$BD);
  echo 'Bienvenido '.$user.' a la base de datos '.$DB .'.';
} catch (PDOException $error) {
  echo 'Connection error: ' . $error->getMessage();
}

//Daatos 
$date=new DateTime();
$title = 'Tirar la basura' ;
$description = 'Limpiar vitrocerámica' ;
$dateCreated = $date->format('Y/m/d H:i:s');
$dateUpdated = $date->format('d/m/Y H:i:s') ;
$category='Cocina';


///////////////////////////////////Función para añadir
function addTarea($title, $description, $dateCreated, $conect){
  $add = $conect-> prepare ( 'INSERT INTO tareas (Título, Descripción, Fecha_Creación) VALUES (:title, :description, :dateCreated)' );
  try{
    $add-> bindParam ( 'title', $title );
    $add-> bindParam ( 'description', $description ) ;
    $add-> bindParam ( 'dateCreated', $dateCreated ) ;

    if ($add->execute()) {
      echo "Nueva entrada añadida satisfactoriamente.";
    }
  }catch(PDOException $error){
    echo "No se pudo crear el registro". $error->getMessage();
  }
}


///////////////////////////////////Función para Editar
function editTarea($description, $category, $conect){
  $id = 6;
  $edit = $conect->prepare ("UPDATE tareas SET Descripción=:description,Categoría=:category WHERE ID = :id ");
  try{
    //$stmt= $conect->prepare($sql)->execute([$description, $category, $id]);
    $edit-> bindValue ( ':description', $description , PDO::PARAM_STR);
    $edit-> bindValue ( ':category', $category, PDO::PARAM_STR ) ;
    $edit-> bindValue ( ':id', $id , PDO::PARAM_INT) ;

    //$stmt->execute([$description, $category, $id]);

    if ($edit->execute()) {
      echo "Actualización realizada con éxisto.";
    } 
  }catch(PDOException $error){
    echo "No se pudo editar.". $error->getMessage();
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
  
///////////////////////////////////Llamada funciones.
//addTarea($title, $description, $dateCreated,$conect);
editTarea($description, $category, $conect);
?>

<html>
  <header> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </header>
  <body>
    <h1>Bienvenid@ a TodoList</h1>
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
  </body>
  <footer></footer>
</html>