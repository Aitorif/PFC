<?php 
if(!isset($_COOKIE["login"]) || $_COOKIE["login"] != "loged"){
    header('Location: index.php');
    exit();
}

include('../modelo/bd.php');
$bd = new Crud();
if($_SESSION['trabajador'] == true){
    $result = $bd->ejecutarConsulta("SELECT COUNT(*) as total FROM documentos as d INNER JOIN user as t ON d.propietario = t.id WHERE d.propietario = $user_id");
    $total = $result->fetch()['total'];
}else{
    $result = $bd->ejecutarConsulta("SELECT COUNT(*) as total FROM documentos as d INNER JOIN documento_compartido as dc ON d.id = dc.id_documento INNER JOIN user AS t ON dc.id_trabajador = t.id WHERE dc.id_user = $user_id");
    $total = $result->fetch()['total'];
}