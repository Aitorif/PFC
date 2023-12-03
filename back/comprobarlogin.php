<?php
    require_once('../modelo/bd.php');
    if(isset($_POST['enviar'])){
        if(isset($_POST['trabajador'])){
            $BaseDeDatos = new Crud();
            $email = trim($_POST['email']);
            $contraseña = trim($_POST['contraseña']);
            $comprobacion = $BaseDeDatos->comprobarUsuario($email, $contraseña, true);
            if($comprobacion === true){
                $resultado = $BaseDeDatos->ejecutarConsulta("SELECT nombre, apellidos, email, id, rol FROM trabajadores WHERE email = '$email'");
                $datos = $resultado->fetch();
                $datos["trabajador"] = true;
                require_once('iniciarSesion.php');
            }else{
                $error = "El email o la contraseña no son correctos";
                require_once('../vista/admin-login.php');
            }
        }else{
            $BaseDeDatos = new Crud();
            $email = trim($_POST['email']);
            $contraseña = trim($_POST['contraseña']);
            $comprobacion = $BaseDeDatos->comprobarUsuario($email, $contraseña, false);
            if($comprobacion === true){
                $resultado = $BaseDeDatos->ejecutarConsulta("SELECT nombre, apellidos, email, id FROM user WHERE email = '$email'");
                $datos = $resultado->fetch();
                $datos["trabajador"] = false;
                require_once('iniciarSesion.php');
            }else{
                $error = "El email o la contraseña no son correctos";
                require_once('../vista/login.php');
            }
        }


    }

?>