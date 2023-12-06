<?php
session_start();

if(!isset($_COOKIE["login"]) || $_COOKIE["login"] != "loged"){
    header('Location: index.php');
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('../modelo/bd.php');
    $Crud = new Crud();
    $user_id = $_SESSION['user_id'];
    $rol = $_SESSION['rol'];
    $indiceInicio = $_POST["indiceInicio"];
    if($rol == "admin"){
        $result = $Crud->ejecutarConsulta("SELECT id, fecha FROM facturas LIMIT $indiceInicio, 10");
    }else{
        $result = $Crud->ejecutarConsulta("SELECT id, fecha FROM facturas WHERE id_user = $user_id LIMIT $indiceInicio, 10");
    }
    if($result != false){
        $documentos = $result->fetchAll();
        $documentosJson = json_encode($documentos);
        echo $documentosJson;
    }else{
        var_dump($result);
    }

}