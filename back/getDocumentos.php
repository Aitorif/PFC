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
    $trabajador = $_SESSION['trabajador'];
    $indiceInicio = $_POST["indiceInicio"];
    if($trabajador == true){
        $result = $Crud->ejecutarConsulta("SELECT d.id, d.titulo, d.ultima_modificacion, t.nombre FROM documentos as d INNER JOIN trabajadores as t ON d.propietario = t.id WHERE d.propietario = $user_id LIMIT $indiceInicio, 10");
    }else{
        $result = $Crud->ejecutarConsulta("SELECT d.id, d.titulo, t.nombre FROM documentos as d INNER JOIN documento_compartido as dc ON d.id = dc.id_documento INNER JOIN trabajadores AS t ON dc.id_trabajador = t.id WHERE dc.id_user = $user_id LIMIT $indiceInicio, 10");
    }

    $documentos = $result->fetchAll();
    $documentosJson = json_encode($documentos);
    echo $documentosJson;
}