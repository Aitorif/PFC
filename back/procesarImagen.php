<?php
if (isset($_FILES['archivo'])) {

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
    $ruta_destino = $directorio_destino . $nombre_archivo;
    move_uploaded_file($ruta_temporal, $ruta_destino);

    $respuesta = "La imagen se ha subido correctamente.";

    // Aquí puedes realizar otras operaciones, como guardar la ruta en una base de datos, etc.

} else {
    $respuesta = "El archivo no es una imagen válida.";
}

} else {
echo "No se ha enviado ningún archivo.";
}
?>