<?php
 require_once('../modelo/bd.php');
 session_start();
 $crud = new Crud();
if(!isset($_POST["inputAdmin"])){

    $id = trim($_POST["user_id"]);
    $email = trim($_POST["nuevoEmail"]);
    $pass = trim($_POST["nuevaContraseña"]);
    if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] == UPLOAD_ERR_OK) {

        // Definir el directorio de destino para guardar la imagen
        $directorio_destino = '../assets/uploads/user-img/';
        
        // Obtener información del archivo
        $nombre_archivo = $_FILES['archivo']['name'];
        $tipo_archivo = $_FILES['archivo']['type'];
        $tamano_archivo = $_FILES['archivo']['size'];
        $ruta_temporal = $_FILES['archivo']['tmp_name'];
        
        // Verificar que el archivo sea una imagen
        $es_imagen = getimagesize($ruta_temporal);
        if ($es_imagen !== false) {
        
            // Mover el archivo al directorio de destino
            $ruta_destino =  $directorio_destino . $id .$nombre_archivo;
            move_uploaded_file($ruta_temporal, $ruta_destino);
            
            echo "La imagen se ha subido correctamente. ";

            $archivo = "$id"."$nombre_archivo";
            $archivoAntiguo = $directorio_destino.$_SESSION['foto'];
            $resultado = $crud->actualizarUsuario($id, $pass, $archivo, $archivoAntiguo);
            
            if($resultado === true){
                if (file_exists($archivoAntiguo) && $archivoAntiguo != $directorio_destino."userphoto.png") {
                    unlink($archivoAntiguo);
                    echo "La foto ha sido eliminada correctamente.";
                } else {
                    echo "No se encontró la foto para eliminar.";
                }
                $_SESSION['pass'] = $pass;
                $_SESSION['foto'] = $archivo;
                echo "Se ha actualizado con éxito";
            }else{
                echo $resultado;
            }

        
        } else {
            echo "El archivo no es una imagen válida.";
        }
        
    } else {

        $resultado = $crud->actualizarUsuario($id, $pass);
        if($resultado === true){
            echo "Se ha actualizado con éxito";
            $_SESSION["email"] = $email;
            $_SESSION["pass"] = $pass;
        }else{
            echo "Ha habido un problema actualizando el usuario. Por favor, inténtalo más tarde.";
        }

    }



}else{
    $datosJSON = urldecode($_POST['datos']);
    $datos = json_decode($datosJSON, true);
    foreach ($datos as $clave => $valor) {
        $resultado = $crud->actualizarRol($clave, $valor) ;
    }
    
    if($resultado === true){
        echo "Se ha actualizado con éxito";
    }else{
        echo "Ha habido un problema actualizando los usuario. Por favor, inténtalo más tarde.";
    }

}

?>
