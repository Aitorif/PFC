<?php
include('../modelo/bd.php');
    $bd = new Crud();
    $user_id = $_SESSION['user_id'];
    $trabajador = $_SESSION['trabajador'];
    $rol = $_SESSION["rol"];
    $result = $bd->getCitas($rol, $user_id, $trabajador);

