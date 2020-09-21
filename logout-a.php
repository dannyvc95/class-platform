<?php
	session_start();
	session_destroy();
	unset($_COOKIE["idA"]);
	setcookie("idA", null, -1, '/');
	unset($_COOKIE["nameA"]);
	setcookie("nameA", null, -1, '/');

	header("location: iniciar-alumno.php");
?>