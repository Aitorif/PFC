<?php

require_once("../modelo/bd.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $Crud = new Crud();
    if(!isset($_POST["inputAdmin"])){
        $nombre = trim($_POST['nombre']);
        $apellidos = trim($_POST['apellidos']);
        $email = trim($_POST['email']);
        $contraseña = trim($_POST['contraseña']);
        $comprobacion = $Crud->comprobarUsuario($email, $contraseña, false);
        if($comprobacion === false){
            $resultado = $Crud->crearUsuario($nombre, $apellidos, $email, $contraseña);
            if($resultado === true){
                $error = "Se ha creado el usuario con éxito";
                header('Location: gestorUsuarios.php');
            }else{
                $result= $resultado;
                require_once('crearUsuario.php');
            }
            
        }else{
            $result = "Ya hay un usuario con esta direccion de email";
            require_once('crearUsuario.php');
        }
    }else{
        $nombre = trim($_POST['nombre']);
        $apellidos = trim($_POST['apellidos']);
        $dni = trim($_POST['dni']);
        $telefono = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $contraseña = trim($_POST['contraseña']);
        $rol = trim($_POST['rol']);
        $comprobacion = $Crud->comprobarUsuario($email, $contraseña, true);
        if($comprobacion === false){
            $resultado = $Crud->crearUsuarioAdmin($nombre, $apellidos, $email, $dni, $rol, $contraseña);
            if($resultado === true){
                $error = "Se ha creado el usuario con éxito";
                require_once('gestorUsuarios.php');
            }else{
                $result= $resultado;
                require_once('nuevoUsuarioAdmin.php');
            }
            
        }else{
            $result = "Ya hay un usuario con esta direccion de email";
            require_once('nuevoUsuarioAdmin.php');
        }

    }

}
?>