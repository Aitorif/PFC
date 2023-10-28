<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/editor.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="Rich-Text-Editor-jQuery-RichText/src/richtext.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="./Rich-Text-Editor-jQuery-RichText/src/jquery.richtext.min.js"></script>
    <title>Clínica Logopédica Castiñeira</title>
</head>
<body>
    <?php
        include('header.php');
        echo $_SESSION["user_id"];
        include('bd.php');
    ?>
    <main>
        <div id="editor">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="formTexto">
            <label for="titulo">Título del documento</label><input type="text" name="titulo">
            <textarea name="example" class="content" id="editor"></textarea>
            <input type="hidden" name="id" value="<?php echo $_SESSION["user_id"]; ?>">
            <button id="guardar" style="margin-top: 20px;">Guardar</button>
            <input type="submit" value="enviar" name="enviar">
            </form>
        </div>
        <?php

            if(isset($_POST['enviar'])){
                $Crud = new Crud();
                $documento = trim($_POST['example']);
                $titulo = trim($_POST['titulo']);
                $usuario = trim($_POST['id']);
                $resultado = $Crud->guardarDocumento($documento, $usuario, $titulo);
                if($resultado === true){

                }else{
                    echo $resultado;
                }
            }
        ?>
        <script>
        $(document).ready(function() {
            $('.content').richText(

            );
        });

        $('#enviar').on('click', function(){
            $('#resultado').append($('#texto').val());
            console.log($('#texto').val());
            
        })

        </script>
    </main>
    <p id="resultado" style="padding: 50px;"></p>
</body>
</html>