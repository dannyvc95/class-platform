<?php
include "config.php";
    
$idAlumno = $_GET["idAlumno"];
$idTarea = $_GET["idTarea"];
$crns = $_GET["crn"];
$id = $_GET["id"];
    
$con = mysqli_connect($server, $user, $password, $db);
$sql = "INSERT INTO `alumnoTarea` (id,idAlumno,idTarea,estado) VALUES (NULL,'$idAlumno','$idTarea', 1)";
$res = mysqli_query($con, $sql);
mysqli_close($con);
    
header("location: entregas-maestro.php?idAlumno=$idAlumno&crn=$crns");
//echo "<meta http-equiv=refresh content=0;URL=alumnos.php?crns=".$crnTarea." />";
?>