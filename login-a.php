<?php
include "config.php";

session_start();  // iniciar sesion.

// obtener datos json del servidor.
$datos_externos = $_POST["datos"];
$datos = explode(",",$datos_externos);

// SOLO EL ALUMNO PUEDE INICIAR SESION.
if ($datos[0] == "A") {
    // manejo de sesion.
$_SESSION["idA"] = $datos[1];
$_SESSION["nombreA"] = $datos[2];

// cookies.
setcookie("idA", $datos[1], time() + (86400 * 30), "/");
setcookie("nameA", $datos[2], time() + (86400 * 30), "/");

// foto.
$foto = $datos[5];
$img = base64_decode($foto);
file_put_contents('img/foto.png',$img);

$conexion = mysqli_connect($server,$user,$password,$db);
$consulta = "SELECT * FROM `maestro`";
$resultado = mysqli_query($conexion,$consulta);
$hay_datos = mysqli_num_rows($resultado);
mysqli_close($conexion);

if ($hay_datos == 0) {
    // cargar informacion a la base de datos.
    // MAESTRO.
    $con = mysqli_connect($server, $user, $password, $db);
    $sql = "INSERT INTO `maestro` (id,nombre,codigo) VALUES (NULL,'$datos[2]','$datos[1]')";
    $res = mysqli_query($con, $sql);
    mysqli_close($con);
        
    // MATERIAS Y ALUMNOS.
    $url = "http://148.202.152.33/horarioMaestro.php";
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);
        
    // conectar con la base de datos.
    $con2 = mysqli_connect($server, $user, $password, $db);
        
    // cargar valores.
    $ciclo = $json_data["ciclo"];
        
    for ($i=0; $i<sizeof($json_data['horario']); $i++) {
        $crn = $json_data["horario"][$i]["crn"];
        $campus = $json_data["horario"][$i]["campus"];
        $seccion = $json_data["horario"][$i]["seccion"];
        $clave = $json_data["horario"][$i]["clave_materia"];
        $materia = $json_data["horario"][$i]["nombre_materia"];
        $horario = $json_data["horario"][$i]["horario"];
        $dias = $json_data["horario"][$i]["dias"];
        $edificio = $json_data["horario"][$i]["edificio"];
        $aula = $json_data["horario"][$i]["aula"];
            
        // Insertar materia
        $sql2 = "INSERT INTO `materia` (id,crn,campus,seccion,clave,materia,horario,dias,edificio,aula) VALUES (NULL,'$crn','$campus','$seccion','$clave','$materia','$horario','$dias','$edificio','$aula')";
        mysqli_query($con2, $sql2);
            
        $alumnos = json_decode($json_data['horario'][$i]['alumnos']);
        
        foreach ($alumnos as $alumno) {
            $codigoAlumno = $alumno->codigo_alumno;
            $nombreAlumno = $alumno->nombre_alumno; 
            $carreraAlumno = $alumno->carrera;
        
            $sql3 = "INSERT INTO `alumno` (id,codigo,nombre,carrera,crns) VALUES (NULL,'$codigoAlumno','$nombreAlumno','$carreraAlumno','$crn')";
            mysqli_query($con2, $sql3);
        }
    }
    mysqli_close($con2);
}

// ir al menu del alumno.
echo "<meta http-equiv=refresh content=0;URL=menu-alumno.php />";
} else {
    echo "<meta http-equiv=refresh content=0;URL=iniciar-alumno.php />";
}



?>