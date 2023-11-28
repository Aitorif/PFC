<?php

require_once("bd.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $Crud = new Crud();
    $cita_id = trim($_POST['cita']);
    $resultado = $Crud->borrarCita($cita_id);

    if($resultado[0] === true){
        echo $resultado;
    }else{
        echo "Ha habido un error";
    }
}
?>