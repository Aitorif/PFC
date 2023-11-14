<?php
session_start();
include('bd.php');
if(!isset($_COOKIE["login"]) || $_COOKIE["login"] != "loged"){
    header('Location: index.php');
    exit();
}
if(isset($_GET['id_document'])){
    $Crud = new Crud();
    $id = $_GET['id_document'];
    $user_id = $_SESSION['user_id'];
    $resultado = $Crud->ejecutarConsulta("SELECT documento, titulo FROM documentos WHERE id = '$id' AND propietario = '$user_id'");
    $listado = $resultado->fetch();
    $documento = $listado['documento'];
    $titulo = $listado['titulo'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/editor.css">

    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="Rich-Text-Editor-jQuery-RichText/src/richtext.min.css">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
-->  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="./Rich-Text-Editor-jQuery-RichText/src/jquery.richtext.min.js"></script>
    <script type="text/javascript" src="./scripts/jquery.printarea.js"></script>
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
            $('document').ready(function(){
                var documento = '<?php echo $documento ;?>';
                $('#texto').html(documento);
                $('#titulo').html("<?php echo $titulo;?>"); 

                $("#imprimir")[0].style.display = "none";
                window.print();
                $(window).on("afterprint", function(){
                    $("#imprimir")[0].style.display = "";
                });
                $("#imprimir").click(function (){
                    this.style.display = "none";
                    window.print();
                    this.style.display = "";
                })
            })
      

    </script>
 </body>
