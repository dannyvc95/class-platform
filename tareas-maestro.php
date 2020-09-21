<?php 
include "config.php";

session_start();
$crn = $_GET["crn"];

if (!isset($_COOKIE["idM"])) {
    echo "<meta http-equiv=refresh content=0;URL=iniciar-maestro.php />";   
}

// operaciones con la base de datos.
// TAREAS.
$con = mysqli_connect($server, $user, $password, $db);
$sql = "SELECT * FROM `tarea` WHERE crnMateria='$crn'";
$res = mysqli_query($con, $sql);
mysqli_close($con);
// ALUMNOS.
$con2 = mysqli_connect($server,$user,$password,$db);
$sql2 = "SELECT * FROM `alumno` WHERE crns='$crn'";
$res2 = mysqli_query($con2, $sql2);  
mysqli_close($con2);
// TAREAS.
$con3 = mysqli_connect($server,$user,$password,$db);
$sql3 = "SELECT * FROM `tarea` WHERE crnMateria='$crn'";
$res3 = mysqli_query($con3, $sql3);
$numero_tareas = mysqli_num_rows($res3);
$filaTareas = mysqli_fetch_array($res3);
mysqli_close($con3);

$con4 = mysqli_connect($server,$user,$password,$db);
$sql4 = "SELECT * FROM `materia` WHERE crn='$crn'";
$res4 = mysqli_query($con4, $sql4);
$fila4 = mysqli_fetch_array($res4);
mysqli_close($con4);


?>
<?php if (isset($_COOKIE["idM"])) { ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="uft-8">
        <title>Control de Actividades</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <script type="text/javascript" src="js/popper.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    </head>
    <body class="text-center">
        <header>
            <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
              <div class="container">
                <a class="navbar-brand" href="menu-maestro.php">Control de actividades</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
        
                <div class="collapse navbar-collapse" id="navbarsExample07">
                  <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                      <a class="nav-link" href="menu-maestro.php">Inicio <span class="sr-only">(current)</span></a>
                    </li>
                  </ul>
                  <span class="navbar-text">Bienvenido, <strong><?php echo $_COOKIE["nameM"]; ?></strong></span>&nbsp;&nbsp;&nbsp;
                  <a href='logout-m.php'><button type='button' class='btn btn-danger btn-sm'>Cerrar sesión</button></a>
                </div>
              </div>
            </nav>
        </header>
        <br><br><br>
        <div class="container">
            <div class="col-sm-12">
                <h3><?php echo ($fila4["materia"])." | ".($fila4["seccion"]); ?></h3>
                <br>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <h3>Tareas del grupo</h3><br>
                    <div class="table-responsive">
                        <table class="table">
                              <thead class="thead-dark">
                                <tr>
                                  <th scope="col">No. Tarea</th>
                                  <th scope="col">Descripción</th>
                                  <th scope="col">Fecha</th>
                                  <th scope="col"></th>
                                  <th scope="col"></th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php 
                                        while ($fila = mysqli_fetch_array($res)) {
                                            echo "
                                                    <tr>
                                                        <th scope='row'>".$fila['numero']."</th>
                                                        <td>".$fila['descripcion']."</td>
                                                        <td>".$fila['fecha']."</td>
                                                        <td><a href='delete-homework.php?id=".$fila['id']."&crn=".$crn."'><button type='button' class='btn btn-danger btn-sm'>Eliminar</button></a></td>
                                                        <td><a href='modificar-tarea.php?id=".$fila['id']."&crn=$crn'><button type='button' class='btn btn-warning btn-sm'>Modificar</button></a></td>
                                                    </tr>
                                            ";
                                        }
                                    ?>
                            
                              </tbody>
                            </table>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <h3>Alumnos del grupo</h3><br>
                    <div class="table-responsive">
                        <table class="table">
                              <thead class="thead-dark">
                                <tr>
                                <th scope='col'>No.</th>
                                <th scope='col'>Código</th>
                                <th scope='col'>Nombre</th>
                                <th scope='col'>Carrera</th>
                                <th scope='col'></th>
                                </tr>
                                </thead>
                              <tbody>
                                
                                <?php 
                                    while ($fila2 = mysqli_fetch_array($res2)) {
                                        echo "
                                                <tr>
                                                    <th scope='row'>".$fila2['id']."</th>
                                                    <td>".$fila2['codigo']."</td>
                                                    <td>".$fila2['nombre']."</td>
                                                    <td>".$fila2['carrera']."</td>
                                                    <td><a href='entregas-maestro.php?idAlumno=".$fila2['id']."&crn=$crn'><button type='button' class='btn btn-primary btn-sm'>Ver entregas</button></a></td>
                                                </tr>      
                                        ";
                                    }
                                ?>
                                
                              </tbody>
                            </table>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <h3>Agregar una tarea</h3><br>
                    <form action="new-homework.php" method="post">
                        <div class="form-group">
                        <input name="numeroTarea" class="form-control" placeholder="Número de tarea">
                        <input name="crnTarea" type="hidden" value="<?php echo $crn; ?>">
                        </div>
                        <div class="form-group">
                        <input name="descripcionTarea" class="form-control" placeholder="Descripción de la tarea">
                        </div>
                        <div class="form-group">
                        <input name="fechaTarea" class="form-control" placeholder="Fecha de entrega">
                        </div>
                        <button type="submit" class="btn btn-success bt-sm">Añadir tarea</button>
                    </form>
                    
                </div>
            </div>
        </div>
        <br><hr>
<div class="container">
	<footer class="text-center">
	  <p>Copyright &copy; 2018 Daniel Valle Contreras.</p>
	</footer>
</div>
</body>
</html>
<?php } ?>