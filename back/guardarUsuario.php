<?php

require_once("../modelo/bd.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $Crud = new Crud();
    if(!isset($_POST["inputAdmin"])){
        $nombre = trim($_POST['nombre']);
        $apellidos = trim($_POST['apellidos']);
        $dni = trim($_POST['DNI']);
        $telefono = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $contraseña = trim($_POST['contraseña']);
        $direccion = trim($_POST['direccion']);
        $comprobacion = $Crud->comprobarUsuario($email, $contraseña);
        if($comprobacion === false){
            $resultado = $Crud->crearUsuario($nombre, $apellidos, $email, $contraseña, $direccion, $telefono, $dni);
            if($resultado === true){
                $error = "Se ha creado el usuario con éxito";
                header('Location: ../vistas/login.php');
            }else{
                $result= $resultado;
                require_once('../vistas/crearUsuario.php');
            }
            
        }else{
            $result = "Ya hay un usuario con esta direccion de email";
            require_once('../vista/crearUsuario.php');
        }
    }else{
        $nombre = trim($_POST['nombre']);
        $apellidos = trim($_POST['apellidos']);
        $dni = trim($_POST['DNI']);
        $telefono = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $contraseña = trim($_POST['contraseña']);
        $direccion = trim($_POST['direccion']);
        $rol = trim($_POST['rol']);
        $trabajador = "true";
        $comprobacion = $Crud->comprobarUsuario($email, $contraseña, true);
        if($comprobacion === false){
            $resultado = $Crud->crearUsuario($nombre, $apellidos, $email, $contraseña, $direccion, $telefono, $dni, $rol, $trabajador);
            if($resultado === true){
                $error = "Se ha creado el usuario con éxito";
                header('Location: ../vistas/gestorUsuarios.php');
            }else{
                $result= $resultado;
                require_once('../vistas/nuevoUsuarioAdmin.php');
            }
            
        }else{
            $result = "Ya hay un usuario con esta direccion de email";
            require_once('../vistas/nuevoUsuarioAdmin.php');
        }

    }

}
?>