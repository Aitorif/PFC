<?php

require_once("../modelo/bd.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $Crud = new Crud();
    $user_id = trim($_POST['userid']);
    $arraydoc_id = $_POST['arraydoc_id'];
    $resultado = $Crud->borrarDocumentos($arraydoc_id, $user_id);

    if($resultado[0] === true){
        echo $resultado;
    }else{
        echo "Ha habido un error";
    }
}
?>