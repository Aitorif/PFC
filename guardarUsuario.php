<?php

require_once("bd.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $Crud = new Crud();
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $contraseña = trim($_POST['contraseña']);
    $comprobacion = $Crud->comprobarUsuario($email, $contraseña, false);
    if($comprobacion === false){
        $resultado = $Crud->crearUsuario($nombre, $apellidos, $email, $contraseña);
        if($resultado === true){
            $error = "Se ha creado el usuario con éxito";
            require_once('login.php');
        }else{
            $result= $resultado;
            require_once('crearUsuario.php');
        }
        
    }else{
        $result = "Ya hay un usuario con esta direccion de email";
        require_once('crearUsuario.php');
    }
}
?>