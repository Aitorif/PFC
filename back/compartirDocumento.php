<?php

require_once("../modelo/bd.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $Crud = new Crud();
    $user_id = trim($_POST['user_id']);
    $email = trim($_POST['email']);
    $arraydoc_id = $_POST['arraydoc_id'];
    $emailValido = $Crud->ejecutarConsulta("SELECT id from user WHERE email = '$email'");
    $id = $emailValido->fetch();
    if($id !== false){
        $resultado = $Crud->compartirDocumento($arraydoc_id, $id['id'], $user_id);
        if($resultado == true){
            return true;
        }else{
            http_response_code(500);
            echo $resultado;
        }
    }else{
        http_response_code(500);
        echo "El email no es correcto";
    }


}
?>