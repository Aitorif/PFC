<?php

session_start();
$_SESSION["user_id"] = $datos["id"];
$_SESSION["nombre"] = $datos["nombre"];
$_SESSION["apellidos"] = $datos["apellidos"];
$_SESSION["email"] = $datos["email"];

setcookie("login", "loged");
header("Location: editor.php");
exit();