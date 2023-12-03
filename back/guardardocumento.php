<?php

require_once("../modelo/bd.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $Crud = new Crud();
    $documento = trim($_POST['documento']);
    $titulo = trim($_POST['titulo']);
    $usuario = trim($_POST['userid']);
    if(!isset($_POST["id_document"])){
        $resultado = $Crud->guardarDocumento($documento, $usuario, $titulo);
    }else{
        $id = $_POST["id_document"];
        $resultado = $Crud->actualizarDocumento($documento, $id);
    }

    if($resultado[0] === true){
        echo $resultado[1];
    }else{
        echo "Ha habido un error";
    }
}
?>