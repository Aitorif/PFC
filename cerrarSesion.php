<?php

session_start();
$_SESSION = array();

setcookie("login", "", time() -42000);
session_destroy();
header("Location: index.php");
exit();