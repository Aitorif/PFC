<?php
session_start();

if(!isset($_COOKIE["login"]) || $_COOKIE["login"] != "loged"){
    header('Location: index.php');
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include('bd.php');
    $Crud = new Crud();
    $cliente = $_GET["cliente"];
    $result = $Crud->ejecutarConsulta("SELECT nombre, apellidos, dni, direccion FROM user WHERE id = $cliente");
    $datos = $result->fetchAll();
    $datosJson = json_encode($datos);
    echo $datosJson;
}