<?php

require_once("../modelo/bd.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $Crud = new Crud();
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $pass = trim($_POST['pass']);
    
    $resultado = $Crud->nuevoUsuario($email, $pass, $nombre, $apellidos);

    $result = $resultado;
    require_once('registroUsuario.php');
}
?>