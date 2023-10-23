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
        require('bd.php');
        $Crud = new Crud('trabajadores');
        $nombre = $Crud->getByEmail('aitor@clinicacastineira.com');
        echo $nombre;
    ?>
    <div class="divContacto">
        <div><img class="pngs" src="./media/telefono.png"/><span>981254789</span></div>
        <div><img class="pngs" src="./media/email.png"/><span>ejemplo@clinicacastineira.com</span></div>
        <div><a href="#"><img class="pngs" src="./media/insta.png"/></a><a href="#"><img class="pngs" src="media/facebook.png"/></a></div>  
    </div>
    <header class="Header">
        <div class="divHeader">
            <a href="#" class="logo"><div ><h2 class="h2Logo">Clinica Castiñeira</h2></div></a>
            <div id="contNav">
                <span>Bienvenid@ a la clínica</span>
                <nav>
                    <ul class="menu">
                        <a href="#"><li class="menuItem">Inicio</li></a>
                        <a href="#"><li class="menuItem">Sobre nosotras</li></a>
                        <a href="#"><li class="menuItem">Nuestro equipo</li></a>
                        <a href="#"><li class="menuItem">Login</li></a>
                        <a href="#"><li class="menuItem">Contacto</li></a>
                    </ul>
                </nav>
            </div>

        </div>     
    </header>
    <main>
        <div id="editor">
            <label for="titulo">Título del documento</label><input type="text" >
            <textarea name="example" class="content" id="texto"></textarea>
            <button id="enviar" style="margin-top: 20px;">Enviar</button>
        </div>
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