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
<script>
    $(document).ready(function() {
        $('.content').richText(

        );

        $("#enviar").on("click", function() {
        event.preventDefault();
        var titulo = $("#titulo").val();
        var documento = $("#editortxt").val();
        var userid = $("#userid").val();
        // Realizar la solicitud AJAX
        console.log(123);
        if(id_document == null){
            $.ajax({
            type: "POST", // Puedes usar POST o GET según tus necesidades
            url: "guardardocumento.php", 
            data: {
                titulo: titulo,
                documento: documento,
                userid: userid
            },
            success: function(response) {
                // Mostrar la respuesta del servidor en el div "resultado"
                id_document =response;
            }
        })
        }else{
            $.ajax({
                type: "POST", // Puedes usar POST o GET según tus necesidades
                url: "guardardocumento.php", // Reemplaza con la URL de tu script PHP
                data: {
                    titulo: titulo,
                    documento: documento,
                    userid: userid,
                    id_document: id_document
                },
                success: function(response) {
                    // Mostrar la respuesta del servidor en el div "resultado"
                    $("#resultado").html(response);
                }
            });
        }
    });
    })


</script>

<?php
        include('header.php');
        include('bd.php');
?>
<main>
    <div id="editor">
        <form action="" method="post" id="formTexto">
        <?php 
            if(isset($_GET['id_document'])){
                $Crud = new Crud();
                $id = $_GET['id_document'];
                $user_id = $_SESSION['user_id'];
                $resultado = $Crud->ejecutarConsulta("SELECT documento, titulo FROM documentos WHERE id = '$id' AND propietario = '$user_id'");
                $listado = $resultado->fetch();
                $documentoAntiguo = $listado['documento'];
                $titulo = $listado['titulo'];
                echo "<input type='hidden' name='id_document' value=$id>";
            }
            
        ?>
        <label for="titulo">Título del documento</label><input type="text" name="titulo" id="titulo">
        <textarea name="documento" class="content" id="editortxt"></textarea>
        <input type="hidden" name="userid" value="<?php echo $_SESSION["user_id"]; ?>" id="userid">
        <input type="submit" value="enviar" name="enviar" id="enviar">
        </form>
        <p id="resultado"></p>


    <?php
    if(isset ($_GET['id_document'])){
        $id_document = ($_GET['id_document']);
        echo "<script>
        var id_document = $id_document;
        var documento = '$documentoAntiguo'
            $('#editortxt').html(documento);
            $('#titulo').attr('value', '$titulo');
        </script>";
    }else{
        echo "<script>var id_document = null;</script>";
    } 
    ?>
    </main>

