<?php
require_once('../modelo/bd.php');
session_start();
$crud = new Crud();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = trim($_POST["id"]);
    $resultado = $crud->borrarUsuario($id);
    if($resultado == true){
        echo "Se ha borrado el usuario con id ".$id;
    }else{
        echo "NO se ha podido borrar el usuario";
    }
}