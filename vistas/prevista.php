<?php
session_start();
include('../modelo/bd.php');
include('../modelo/functional.php');
comprobarLogin();


if(isset($_GET['id_document'])){
    $bd = new Crud();
    $id_document = $_GET['id_document'];
    $user_id = $_SESSION['user_id'];
    $listado = $bd->getDocById($id_document, $user_id);

    if($listado !== true && $listado !== false){
        $documento = $listado['documento'];
        $titulo = $listado['titulo'];
    }

}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/editor.css">

    <link rel="stylesheet" href="../estilos/estilos.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
-->  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="../scripts/jquery.previstaDocumento.js"></script>
    <title>Clínica Logopédica Castiñeira</title>
</head>

<body>
    <button id="imprimir" style="display: none">Imprimir</button>
    <div id="documento">
        <h1 id="titulo" style="text-align:center;"></h1>
        <div id="texto">
        </div>
    </div>

    <script>
        let documento = '<?php echo $documento ;?>';
        let titulo = '<?php echo $titulo;?>';
        console.log(titulo);
    </script>
</body>
