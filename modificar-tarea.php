<?php 
include "config.php";

session_start();
$crn = $_GET["crn"];

if (!isset($_COOKIE["idM"])) {
    echo "<meta http-equiv=refresh content=0;URL=iniciar-maestro.php />";   
}

$id=$_GET["id"];
// operaciones con la base de datos.
$con4 = mysqli_connect($server,$user,$password,$db);
$sql4 = "SELECT * FROM `tarea` WHERE id='$id'";
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
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <h3>Actualizar datos de la tarea</h3>
                    <h5>Tarea No: <?php echo $fila4["numero"]; ?></h5>
                    <h5>Descripción: <?php echo $fila4["descripcion"]; ?></h5>
                    <h5>Fecha: <?php echo $fila4["fecha"]; ?></h5>
                    <span class="badge badge-pill badge-danger"><strong>*</strong> Dejar el campo vacío si no se requiere modificar</span><br><br>
                    <form action="update-homework.php" method="post">
                        <div class="form-group">
                        <input name="numero" class="form-control" placeholder="Número de tarea">
                        <input name="id" type="hidden" value="<?php echo $id; ?>">
                        
                        </div>
                        <div class="form-group">
                        <input name="descripcionTarea" class="form-control" placeholder="Descripción de la tarea">
                        <input name="crn" type="hidden" value="<?php echo $crn; ?>">
                        </div>
                        <div class="form-group">
                        <input name="fecha" class="form-control" placeholder="Fecha de entrega">
                        </div>
                        <button type="submit" class="btn btn-warning bt-sm">Modificar tarea</button>
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