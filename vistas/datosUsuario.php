<?php
session_start();

include('../modelo/functional.php');
comprobarLogin();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/editor.css">

    <link rel="stylesheet" href="../estilos/estilos.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
-->  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="../scripts/jquery.datosUsuario.js"></script>
    <title>Clínica Logopédica Castiñeira</title>
</head>
<body>
    <?php 
        include('header.php');
    ?>
    <section id="main-container">
        <div id="contenedorUsuario">
            <div id="botones" style="width:15%">
                <span class="side-btn">Mis datos</span>
                <a href="facturas.php" class="side-btn">Mis facturas</a>
            </div>

            <div id="info">
                <div id="foto-contenedor">
                    <img style="max-width: 200px" src="../assets/uploads/user-img/<?= $_SESSION['foto']?>" alt="foto de usuario">
                    <input type="file" name="archivo" id="archivoInput" accept="image/*">
            </div>
                <div id="info-personal">
                    <label for="nombre">Nombre <input type="text" value="<?= $_SESSION['nombre']?>" readonly ></label>
                    <label for="apellidos">Apellidos <input type="text" value="<?= $_SESSION['apellidos']?>" readonly ></label>
                    <label for="email">Email <input type="email" id="email" value="<?= $_SESSION['email']?>" readonly ></label>
                    <label for="contraseña">Contraseña<input type="password" id="contraseña" value="<?= $_SESSION['pass']?>"><button id="showPassword" class="btn">Ver</button></label>
                    <button id="guardar" class="btn">Guardar datos</button>
                    <div id="pedirContraseña">
                        <label for="contraseña">Introduce tu contraseña<input type="password" id="contraseñaAComprobar">
                        <button id="aceptar" class="btn">Aceptar</button>
                        <p id="errormsg"></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        let contraseña = '<?= $_SESSION["pass"]; ?>';
        let user_id = '<?= $_SESSION["user_id"]; ?>';
    </script>

</body>

