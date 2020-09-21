<?php
include "config.php";
    
$numero = $_POST["numeroTarea"];
$crnTarea = $_POST["crnTarea"];
$descripcion = $_POST["descripcionTarea"];
$fecha = $_POST["fechaTarea"];
    
$con = mysqli_connect($server, $user, $password, $db);
$sql = "INSERT INTO `tarea` (id,numero,crnMateria,descripcion,fecha) VALUES (NULL,'$numero','$crnTarea','$descripcion','$fecha')";
$res = mysqli_query($con, $sql);
mysqli_close($con);
    
header("location: tareas-maestro.php?crn=$crnTarea");
?>