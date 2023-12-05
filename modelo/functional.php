<?php
function comprobarLogin(){
    if(!isset($_COOKIE["login"]) || $_COOKIE["login"] != "loged"){
        header('Location: ../index.php');
        exit();
    }
}

function comprobarTrabajador(){
    if($_SESSION['trabajador'] != true){
        header('Location: ../index.php');
        exit();
    }
}
