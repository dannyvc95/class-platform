<?php 
if (isset($_COOKIE["idA"])) {
    echo "<meta http-equiv=refresh content=0;URL=menu-alumno.php />";
}
?>
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
        
        <link rel="stylesheet" href="css/signin.css">
        <form class="form-signin" action="http://148.202.152.33/2018/datosudeg.php" method="post">
            
            <img class="mb-4" src="https://upload.wikimedia.org/wikipedia/commons/5/5f/Escudo_UdeG.svg" alt="" width="150" height="190">
            <h1 class="h3 mb-3 font-weight-normal">Alumno</h1>
            
            <label for="inputCodigo" class="sr-only">Código</label>
            <input name="codigo" type="text" id="inputCodigo" class="form-control" placeholder="Código" required autofocus>
        
            <input type="hidden" name="web" value="https://danielvalle.000webhostapp.com/app/login-a.php">
        
            <label for="inputNip" class="sr-only">NIP</label>
            <input name="nip" type="password" id="inputNip" class="form-control" placeholder="NIP" required>
        
            <div class="checkbox mb-3">
                <label>
                    <a href="iniciar-maestro.php"><span>Soy un maestro</span></a>
                </label>
            </div>
            
            
            <button class="btn btn-md btn-primary btn-block" type="submit">Iniciar sesión</button><p class="mt-5 mb-3 text-muted">&copy; Daniel Valle Contreras 2018</p>
        </form>
        
    </body>
</html>