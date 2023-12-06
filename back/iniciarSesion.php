<?php

session_start();
$_SESSION["user_id"] = $datos["id"];
$_SESSION["nombre"] = $datos["nombre"];
$_SESSION["apellidos"] = $datos["apellidos"];
$_SESSION["email"] = $datos["email"];
$_SESSION["foto"] = $datos["photo"];
$_SESSION["pass"] = $datos["pass"];
$_SESSION["trabajador"] = $booleano = filter_var($datos["trabajador"], FILTER_VALIDATE_BOOLEAN);
if($_SESSION["trabajador"] == false){
    $_SESSION["rol"] = "paciente";
}else{
    $_SESSION["rol"] = $datos["rol"];
}

setcookie("login", "loged", 0 , "/");
header("Location: ../index.php");
exit();