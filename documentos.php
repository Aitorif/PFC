<?php
session_start();

if(!isset($_COOKIE["login"]) || $_COOKIE["login"] != "loged"){
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/editor.css">
    <link rel="stylesheet" href="estilos/login.css">
    <link rel="stylesheet" href="estilos/estilos.css">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="Rich-Text-Editor-jQuery-RichText/src/richtext.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="./Rich-Text-Editor-jQuery-RichText/src/jquery.richtext.min.js"></script>
    <title>Clínica Logopédica Castiñeira</title>
</head>
<?php 
    include('header.php');
    include('bd.php');
    $Crud = new Crud();
    $user_id = $_SESSION['user_id'];
    $result = $Crud->ejecutarConsulta("SELECT d.id, d.titulo, t.nombre FROM documentos as d INNER JOIN trabajadores as t ON d.propietario = t.id WHERE d.propietario = $user_id");
    if($result->rowCount() > 0){
        $documentos = $result->fetchAll();

    }else{
        echo "<h2>Todavía no tienes documentos</h2>";
    }


?>
<body>
    <div id="documentos">
        <table>
            <tr><td>Título</td></tr>
        <?php

            foreach($documentos as $elementos){
                echo "<tr><td>". $elementos['titulo']."</td></tr>";
            }

        ?>
        </table>

    </div>


</body>