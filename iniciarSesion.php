<?php

session_start();
$_SESSION["user_id"] = $datos["id"];
$_SESSION["nombre"] = $datos["nombre"];
$_SESSION["apellidos"] = $datos["apellidos"];
$_SESSION["email"] = $datos["email"];
$_SESSION["trabajador"] = $datos["trabajador"];
if($_SESSION["trabajador"] == false){
    $_SESSION["rol"] = "paciente";
}else{
    $_SESSION["rol"] = $datos["rol"];
}

setcookie("login", "loged");
header("Location: documentos.php");
exit();