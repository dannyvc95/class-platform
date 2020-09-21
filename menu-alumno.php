<?php 
include "config.php";

session_start();

if (!isset($_COOKIE["idA"])) {
    echo "<meta http-equiv=refresh content=0;URL=iniciar-alumno.php />";   
}

// operaciones con la base de datos.
$codigoAlumno = $_SESSION["idA"];
$con = mysqli_connect($server,$user,$password,$db);
$sql = "SELECT * FROM `alumno` WHERE codigo='$codigoAlumno'";
$res = mysqli_query($con,$sql);
$materiasAlumno = mysqli_num_rows($res);
$arregloCrns = array();
    while ($f = mysqli_fetch_array($res)) {
        array_push($arregloCrns, $f["crns"]);
    }

// datos.
$sqlDatos = "SELECT * FROM `alumno` WHERE codigo='$codigoAlumno'";
$resDatos = mysqli_query($con,$sqlDatos);
$filaDatos = mysqli_fetch_array($resDatos);
$nombreA = $filaDatos["nombre"];
$codigoA = $filaDatos["codigo"];
$carreraA = $filaDatos["carrera"];


mysqli_close($con);
?>
<?php if (isset($_COOKIE["idA"])) { ?>
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
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
              <div class="container">
                <a class="navbar-brand" href="menu-alumno.php">Control de actividades</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
        
                <div class="collapse navbar-collapse" id="navbarsExample07">
                  <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                      <a class="nav-link" href="menu-alumno.php">Inicio <span class="sr-only">(current)</span></a>
                    </li>
                  </ul>
                  <span class="navbar-text">Bienvenido, <strong><?php echo $_COOKIE["nameA"]; ?></strong></span>&nbsp;&nbsp;&nbsp;
                  <a href='logout-a.php'><button type='button' class='btn btn-danger btn-sm'>Cerrar sesión</button></a>
                </div>
              </div>
            </nav>
        </header>
        <br>
        <div class="container">
            <div class="row">
        <div class="col-sm-12">
            <img class="rounded-circle" src="img/foto.png" alt="" width="160" height="160">
            <h2><?php echo $_COOKIE["nameA"]; ?></h2>
            <p><?php echo $codigoA; ?> | <?php echo $carreraA; ?></p>
        </div>
    </div>
    <hr>
            <div class="row">
                <div class="col-md-12">
                    <h3>Materias del alumno</h3><br>
                    <div class="table-responsive">
                        <table class="table">
                              <thead class="thead-dark">
                                <tr>
                                  <th scope="col">Materia</th>
                                  <th scope="col">Clave</th>
                                  <th scope="col">CRN</th>
                                  <th scope="col">Sección</th>
                                  <th scope="col">Horario</th>
                                  <th scope="col"></th>
                                </tr>
                              </thead>
                              <tbody>

                                <?php
                                    for ($i=0; $i<$materiasAlumno; $i++) {
                                        $con2 = mysqli_connect($server,$user,$password,$db);
                                        $sql2 = "SELECT * FROM `materia` WHERE crn='".$arregloCrns[$i]."'";
                                        $res2 = mysqli_query($con2, $sql2);
                                        $fila = mysqli_fetch_array($res2);
                                        
                                        echo "
                                            <tr>
                                                <th scope='row'>".$fila['materia']."</th>
                                                <td>".$fila['clave']."</td>
                                                <td>".$fila['crn']."</td>
                                                <td>".$fila['seccion']."</td>
                                                <td>".$fila['horario']."-".$fila['dias']." | ".$fila['edificio']."-".$fila['aula']."</td>
                                                <td><a href='tareas-alumno.php?crn=".$fila['crn']."&codigo=".$codigoAlumno."'><button type='button' class='btn btn-primary btn-sm'>Ver tareas</button></a></td>
                                            </tr>
                                        ";
                                    }
                                    mysqli_close($con2);
                                ?>

                              </tbody>
                            </table>
                    </div>
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