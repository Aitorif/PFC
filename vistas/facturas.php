<?php
session_start();

include('../modelo/functional.php');
comprobarLogin();
include('../modelo/bd.php');
$Crud = new Crud();
$user_id = $_SESSION['user_id'];
$trabajador =$_SESSION['trabajador'];
$trabajadorJSON = json_encode($_SESSION["trabajador"]);
if($_SESSION['rol'] == "admin"){
    $result = $Crud->ejecutarConsulta("SELECT COUNT(*) as total FROM facturas");
}else{
    $result = $Crud->ejecutarConsulta("SELECT COUNT(*) as total FROM facturas as f INNER JOIN user AS u ON f.id_user = u.id WHERE f.id_user = $user_id");
}
if($result != false){
    $total = $result->fetch()['total'];

}else{
    $total = 0;
}
$entradasPorPagina = 10;
$totalPaginas = ceil($total / $entradasPorPagina);
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
    <script type="text/javascript" src="../scripts/jquery.facturas.js"></script>
    <title>Clínica Logopédica Castiñeira</title>
</head>
<body>
    <?php 
        include('header.php');

    ?>
    <section id="main-container">
        <div id="contenedor">
            <a href="datosUsuario.php">Mis datos</a>
            <span class="side-btn">Mis facturas</span>
            <div id="info">
                <?php
                    if($total == 0){
                        echo "<h3>Todavía no tienes facturas que ver.</h3>";
                    }else{?>
                <table id="tablaDocs" class="table">
                    <tr id="titleTable"><th>ID</th><th>Fecha</th><th></th>
                </table>

                <?php } ?>
            </div>
        </div>
    </section>
    <script>

    </script>

</body>