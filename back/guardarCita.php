<?php

require_once("../modelo/bd.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $Crud = new Crud();
    $dia = trim($_POST['dia']);
    $hora = trim($_POST['hora']);
    $paciente = trim($_POST['paciente']);
    $trabajador = trim($_POST['trabajador']);
    $resultado = $Crud->registrarCita($paciente, $trabajador, $dia, $hora);
    if($resultado != true){
        http_response_code(500);

        // Envía un mensaje de error en el cuerpo de la respuesta
        echo json_encode(array('error' => $resultado));
        exit();
    }else{
        echo $resultado;
    }
    

}
?>