<?php 
include "config.php";

session_start();
$crn = $_GET["crn"];
$idAlumno = $_GET["idAlumno"];

if (!isset($_COOKIE["idM"])) {
    echo "<meta http-equiv=refresh content=0;URL=iniciar-maestro.php />";   
}

// operaciones con la base de datos.
$con = mysqli_connect($server, $user, $password, $db);
$sql = "SELECT * FROM `tarea` WHERE crnMateria='$crn'";
$res = mysqli_query($con, $sql);  
mysqli_close($con);

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
            <div class="row">
                <div class="col-sm-12">
                <h3><?php echo ($fila4["materia"])." | ".($fila4["seccion"]); ?></h3>
                <br>
            </div>
                <div class="col-sm-12">
                    <h3>Tareas del alumno</h3><br>
                    <div class="table-responsive">
                        <table class="table">
                              <thead class="thead-dark">
                                <tr>
                                  <th scope="col">No. Tarea</th>
                                  <th scope="col">Descripción</th>
                                  <th scope="col">Fecha</th>
                                  <th scope='col'>Estado de entrega</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php 
                                    while ($fila = mysqli_fetch_array($res)) {
                                        $con2 = mysqli_connect($server, $user, $password, $db);
                                        $sql2 = "SELECT * FROM `alumnoTarea` WHERE idAlumno='$idAlumno' AND idTarea='".$fila['numero']."'";
                                        $res2 = mysqli_query($con2, $sql2);
                                        $fila2 = mysqli_fetch_array($res2);
                                        mysqli_close($con2);
                                        
                                        if ($fila2['estado'] == 1) {
                                            $estado = "Entregado";
                                            $clase = "table-success";
                                            $disabled = true;
                                        } else {
                                            $estado = "<a href='submit-homework.php?crn=".$crn."&id=".$fila['id']."&idAlumno=".$idAlumno."&idTarea=".$fila['numero']."'><button type='button' class='btn btn-danger btn-sm'>Entregar esta tarea</button>";
                                            $clase = "table-danger";
                                            $disabled = false;
                                        }
                                        if ($disabled == true) {
                                            echo "
                                                <tr>
                                                    <th scope='row'>".$fila['numero']."</th>
                                                    <td>".$fila['descripcion']."</td>
                                                    <td>".$fila['fecha']."</td>
                                                    <td class='".$clase."'>".$estado."</td>
                                                </tr>
                                        ";
                                        } else {
                                            echo "
                                                <tr>
                                                    <th scope='row'>".$fila['numero']."</th>
                                                    <td>".$fila['descripcion']."</td>
                                                    <td>".$fila['fecha']."</td>
                                                    <td class='".$clase."'>".$estado."</td>
                                                </tr>
                                        ";
                                        }
                                        
                                    }
                                ?>
                            
                              </tbody>
                            </table>
                    </div>
                </div>
                
                <div class="col-sm-12">
                <hr>
                <a href="tareas-maestro.php?crn=<?php echo $crn; ?>"><button type='button' class='btn btn-primary btn-md'>Regresar</button></a>
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