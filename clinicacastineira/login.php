<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/editor.css">
    <link rel="stylesheet" href="estilos/login.css">
    <title>Clínica Logopédica Castiñeira</title>
</head>
<body>
    <?php
        include('header.php');
    ?>
    <main>
        <div id="divLogin">
            <div id="textoPresentacion">
                <form action="comprobarlogin.php" method="post">
                    <label for="email">Email</label><input type="email" name="email" placeholder="Escribe tu email" required>
                    <label for="email">Contraseña</label><input type="password" name="contraseña" placeholder="Escribe tu contraseña" required>
                    <input type="submit" name="enviar">
                    <?php if(isset($error)){echo $error;} ?>
                </form>

        </div>
    </main>
</body>
</html>