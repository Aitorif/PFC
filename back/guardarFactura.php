<?php

require_once("../modelo/bd.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $Crud = new Crud();
    $cliente = trim($_POST["cliente"]);
    $fecha = trim($_POST["fecha"]);
    $descripcion = trim($_POST["descripcion"]);
    $cantidad = trim($_POST["cantidad"]);
    $precioUnitario = trim($_POST["precio"]);
    $total = trim($_POST["total"]);
    $resultado = $Crud->guardarFactura($cliente, $fecha, $descripcion, $cantidad, $precioUnitario, $total);
    echo $resultado;

}
?>