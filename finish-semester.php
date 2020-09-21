<?php
    include "config.php";
    
	session_start();
	session_destroy();
	unset($_COOKIE["idM"]);
	unset($_COOKIE["nameM"]);
	setcookie("idM", null, -1, '/');
	setcookie("nameM", null, -1, '/');
	
	// Vaciar las tablas de la base de datos
	$con = mysqli_connect($server, $user, $password, $db);
    $sql = "TRUNCATE TABLE `maestro`; TRUNCATE TABLE `alumno`; TRUNCATE TABLE `materia`; TRUNCATE TABLE `tarea`; TRUNCATE TABLE `alumnoTarea`; ";
    $res = mysqli_query($con,$sql);
    mysqli_close($con);

	header("location: iniciar-maestro.php");
?>