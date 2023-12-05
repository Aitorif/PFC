<?php
    require_once('../modelo/bd.php');
    if(isset($_POST['enviar'])){
        $BaseDeDatos = new Crud();
        $email = trim($_POST['email']);
        $contraseña = trim($_POST['contraseña']);
        $comprobacion = $BaseDeDatos->comprobarUsuario($email, $contraseña, false);
        if($comprobacion === true){
            $resultado = $BaseDeDatos->ejecutarConsulta("SELECT nombre, apellidos, email, id, rol, trabajador FROM user WHERE email = '$email'");
            $datos = $resultado->fetch();
            require_once('iniciarSesion.php');
        }else{
            $error = "El email o la contraseña no son correctos";
            require_once('../vistas/login.php');
        }
    }

?>