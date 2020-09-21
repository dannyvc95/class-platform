<?php
    include "config.php";
    
    if (!isset($_COOKIE["idA"])) {
        echo "<meta http-equiv=refresh content=0;URL=iniciar-alumno.php />";
    } else {
        $crn = $_GET["crn"];
        $codigo = $_GET["codigo"];
        
        $con = mysqli_connect($server, $user, $password, $db);
        $sql = "SELECT * FROM `tarea` WHERE crnMateria='$crn'";
        $res = mysqli_query($con, $sql);  
        mysqli_close($con);
        
        $con3 = mysqli_connect($server, $user, $password, $db);
        $sql3 = "SELECT * FROM `alumno` WHERE codigo='$codigo' AND crns='$crn'";
        $res3 = mysqli_query($con3, $sql3);  
        $fila3 = mysqli_fetch_array($res3);
        mysqli_close($con3);
        
        $id = $fila3['id'];
        
        $nombreA = $fila3["nombre"];
        $codigoA = $fila3["codigo"];
        $carreraA = $fila3["carrera"];
        
        $con4 = mysqli_connect($server,$user,$password,$db);
$sql4 = "SELECT * FROM `materia` WHERE crn='$crn'";
$res4 = mysqli_query($con4, $sql4);
$fila4 = mysqli_fetch_array($res4);
mysqli_close($con4);
        
    }
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
        <div class="col-sm-12">
                <h3><?php echo ($fila4["materia"])." | ".($fila4["seccion"]); ?></h3>
                <br>
            </div>
    </div>

    <div class="row">
        
        <div class="col-sm-12"><hr>
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                <tr>
                <th scope='col'>No. Tarea</th>
                <th scope='col'>Descripción</th>
                <th scope='col'>Fecha</th>
                <th scope='col'>Estado de entrega</th>
                </tr>
                </thead>
            <tbody>
            <?php 
                while ($fila = mysqli_fetch_array($res)) {
                    $con2 = mysqli_connect($server, $user, $password, $db);
                    $sql2 = "SELECT * FROM `alumnoTarea` WHERE idAlumno='$id' AND idTarea='".$fila['numero']."'";
                    $res2 = mysqli_query($con2, $sql2);
                    $fila2 = mysqli_fetch_array($res2);
                    mysqli_close($con2);
                    
                    if ($fila2['estado'] == 1) {
                        $estado = "Entregado";
                        $clase = "table-success";
                        $disabled = true;
                    } else {
                        $estado = "Sin entregar";
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
    <div class="row">
        <div class="col-sm-12">
        
            <?php
                $con9 = mysqli_connect($server, $user, $password, $db);
                $sql9 = "SELECT * FROM `tarea` WHERE crnMateria='$crn'";
                $res9 = mysqli_query($con9, $sql9);
                $totalTareas = mysqli_num_rows($res9);
                mysqli_close($con9);
                
                $con99 = mysqli_connect($server, $user, $password, $db);
                $sql99 = "SELECT * FROM `alumnoTarea` WHERE idAlumno='$id' AND estado=1";
                $res99 = mysqli_query($con99, $sql99);
                $entregadas = mysqli_num_rows($res99);
                mysqli_close($con99);
                
                $sinEntregar = $totalTareas - $entregadas;
            ?>
            
            <script type="text/javascript">
              google.charts.load("current", {packages:["corechart"]});
              google.charts.setOnLoadCallback(drawChart);
              
              var entregadas = <?php echo $entregadas;?>;
              var sinEntregar = <?php echo $sinEntregar;?>;
              
              function drawChart() {
                var data = google.visualization.arrayToDataTable([
                  ['Task', 'Hours per Day'],
                  ['Entregadas',     entregadas],
                  ['Sin entregar',      sinEntregar]
                ]);
        
                var options = {
                  title: 'Entrega de actividades',
                  pieHole: 0.4,
                  colors: ['#6ee689', '#f84659']
                };
        
                var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
                chart.draw(data, options);
              }
            </script>
            <hr>
            <center>
            <div id="donutchart" style="width: 650px; height: 400px;"></div>
            </center>
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