<?php
	session_start();
//	session_destroy();
	unset($_COOKIE["idM"]);
	setcookie("idM", null, -1, '/');
	unset($_COOKIE["nameM"]);
	setcookie("nameM", null, -1, '/');

	header("location: iniciar-maestro.php");
?>