<?php
session_start();

if(!isset($_COOKIE["login"]) || $_COOKIE["login"] != "loged"){
    header('Location: index.php');
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include('../modelo/bd.php');
    $bd = new Crud();
    $id = $_GET["cliente"];
    $datos = $bd->getUserById($id);
    $datosJson = json_encode($datos);
    echo $datosJson;
}