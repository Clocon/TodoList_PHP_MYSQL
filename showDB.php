<html>
  <header> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </header>
  <body>
    <div>
      <div>
        <h3>Añade una tarea a tu lista</h3>
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
          require_once './database.php';
          consultTarea($conect); ?>
        </table>
      </div>  
    </div>
  </body>
  <footer></footer>
</html>
