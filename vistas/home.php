<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/editor.css">
    <link rel="stylesheet" href="../estilos/login.css">
    <link rel="stylesheet" href="../estilos/estilos.css">
    <link rel= "stylesheet" type= "text/css" herf= "http.//fonts.googleapis.com/css?family=Nunito+Sans">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../Rich-Text-Editor-jQuery-RichText/src/richtext.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="../Rich-Text-Editor-jQuery-RichText/src/jquery.richtext.min.js"></script>
    <script type="text/javascript" src="../scripts/jquery.home.js"></script>
    <title>Clínica Logopédica Castiñeira</title>
</head>
<body>
    <section id="main-container">
    <?php
            include('header.php');
            include('../modelo/bd.php');
    ?>

        <div id="presentacion">
        <div id="carousel">
            <div class="slide">
                <img src="../assets/uploads/slider1.jpg" alt="Imagen 1">
            </div>
            <div class="slide">
                <img src="../assets/uploads/slider2.jpg" alt="Imagen 2">
            </div>
            <div class="slide">
                <img src="../assets/uploads/slider3.jpg" alt="Imagen 3">
            </div>
            <button class="prev">Anterior</button>
    <button class="next">Siguiente</button>
        </div>

</div>
            <div id="textoPresentacion">
                <h2>¿Por qué nace la Clínica Castiñeira?</h2>
                <p>
                    Carla Rodríguez funda la clínica en el año 2024 como respuesta a la creciente demanda de un espacio integral, donde se puedan encontrar diversos tipos de apoyo y atención para todas las personas que acudan a nosotros. Nos esforzamos en construir un entorno único y enriquecedor, 
                    diseñado para promover el bienestar y el desarrollo de cada individuo que forma parte de nuestra comunidad.
                </p>
                <p>
                    Somos un equipo formado por personas que se esforzarán al máximo para poder acompañarte y ayudarte en tu desarrollo integral, complementando nuestra visión clínica y artística.
                    Nuestro lema es: Prueba, siente y juega, pero sobre todo, disfruta del camino que haremos juntos.
                </p>
            </div>
        </div>
    </section>
</body>