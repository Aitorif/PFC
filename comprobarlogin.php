<?php
    require_once('bd.php');
    if(isset($_POST['enviar'])){
        $BaseDeDatos = new Crud();
        $email = trim($_POST['email']);
        $contraseña = trim($_POST['contraseña']);
        $comprobacion = $BaseDeDatos->comprobarUsuario($email, $contraseña);
        if($comprobacion === true){
            $resultado = $BaseDeDatos->ejecutarConsulta("SELECT nombre, apellidos, email, id FROM trabajadores WHERE email = '$email'");
            $datos = $resultado->fetch();
            require_once('iniciarSesion.php');
        }else{
            $error = "El email o la contraseña no son correctos";
            require_once('login.php');
        }
    }

?>