
<?php
        session_start();
        if(isset($_COOKIE["login"]) && $_COOKIE["login"] == "loged"){
            header('Location: ../index.php');
            exit();
        }
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/editor.css">
    <link rel="stylesheet" href="../estilos/login.css">
    <link rel="stylesheet" href="../estilos/estilos.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Clínica Logopédica Castiñeira</title>
</head>

<main class="main-login">
    <header class="header" >
        <div class="divHeader" style="height: fit-content">
            <a href="index.php" style="height: fit-content" id="logo" ><div ><img style="width:200px; height:auto" src="../assets/CLINICA_CASTIÑEIRA.png" alt=""></div></a>
        </div>    
    </header>
    <div id="divLogin">
        <div id="textoPresentacion">
            <form action="../back/comprobarlogin.php" method="post">
                <label for="email">Email</label><input type="email" name="email" placeholder="Escribe tu email" required>
                <label for="email">Contraseña</label><input type="password" name="contraseña" placeholder="Escribe tu contraseña" required>
                <input type="hidden" name="trabajador">
                <input type="submit" name="enviar">
                <?php if(isset($error)){echo $error;} ?>
            </form>
        </div>
    </div>
</main>
