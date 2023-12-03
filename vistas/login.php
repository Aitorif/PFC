

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/editor.css">
    <!--<link rel="stylesheet" href="estilos/login.css">-->
    <link rel="stylesheet" href="../estilos/estilos.css">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Clínica Logopédica Castiñeira</title>
</head>
<?php
        session_start();
        if(isset($_COOKIE["login"]) && $_COOKIE["login"] == "loged"){
            header('Location: ../index.php');
            exit();
        }
        include('header.php');
?>  
<main>
    <section id="main-container" class="flex-container">
        <div id="divLogin">
            <h1>Iniciar Sesión</h1>
            <form action="../back/comprobarlogin.php" method="post">
                <label for="email">Email</label><input type="email" name="email" placeholder="Escribe tu email" required>
                <label for="email">Contraseña</label><input type="password" name="contraseña" placeholder="Escribe tu contraseña" required>
                <div class="flex-row"><input type="submit" name="enviar" id="logInButton"></div>
                <?php if(isset($error)){echo $error;} ?>
            </form> 
            <a id="linkLogUp" href="crearUsuario.php">¿Todavía no tienes una cuenta? ¡Regístrate!</a>
        </div>
    </section>
</main>
