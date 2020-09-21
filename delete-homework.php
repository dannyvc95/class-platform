<?php
include "config.php";
$id = $_GET["id"];
$crn = $_GET["crn"];
$conexion = mysqli_connect($server,$user,$password,$db);
$consulta = "DELETE FROM `tarea` WHERE id='$id'";
$resultado = mysqli_query($conexion,$consulta);
mysqli_close($conexion);
header("location: tareas-maestro.php?crn=$crn");
?>