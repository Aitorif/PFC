<?php
session_start();

if(!isset($_COOKIE["login"]) || $_COOKIE["login"] != "loged"){
    header('Location: index.php');
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include('../modelo/bd.php');
    $bd = new Crud();
    $user_id = $_SESSION['user_id'];
    $indiceInicio = $_GET["indiceInicio"];
    $documentos = $bd->getDocumentoPag( $user_id, $indiceInicio);
    $documentosJson = json_encode($documentos);
    echo $documentosJson;
}