<?php
include "config.php";
$id = $_POST["id"];
$nu = $_POST["numero"];
$crnTarea = $_POST["crn"];
$descripcion = $_POST["descripcionTarea"];
$fecha = $_POST["fecha"];


$con = mysqli_connect($server, $user, $password, $db);
$sql = "SELECT * FROM `tarea` WHERE id='$id'";
$res = mysqli_query($con, $sql);
$fila = mysqli_fetch_array($res);
mysqli_close($con);

$oldNumero = $fila["numero"];
$oldDescripcion = $fila["descripcion"];
$oldFecha = $fila["fecha"];

if ($nu == "") {
    $nu = $oldNumero;
}

if ($descripcion == "") {
    $descripcion = $oldDescripcion;
}
if ($fecha == "") {
    $fecha = $oldFecha;
}   

$con2 = mysqli_connect($server, $user, $password, $db);
$sql2 = "UPDATE `tarea` SET numero='$nu', crnMateria='$crnTarea', descripcion='$descripcion', fecha='$fecha' WHERE id='$id'";
$res2 = mysqli_query($con2, $sql2);
mysqli_close($con2);
    
header("location: tareas-maestro.php?crn=$crnTarea");
?>