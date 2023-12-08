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

</body>