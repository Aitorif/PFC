<?php

require_once("bd.php");
    if(isset($_POST['enviar'])){
        $Crud = new Crud();
        $documento = trim($_POST['example']);
        $titulo = trim($_POST['titulo']);
        $usuario = trim($_POST['id']);
        $resultado = $Crud->guardarDocumento($documento, $usuario, $titulo);
        if($resultado === true){

        }else{
            echo $resultado;
        }
    }
?>