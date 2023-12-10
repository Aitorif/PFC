<?php
session_start();

include('../modelo/functional.php');
comprobarLogin();

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
    <script type="text/javascript" src="../scripts/jquery.citas.js"></script>
    <title>Clínica Logopédica Castiñeira</title>
</head>
<?php 
    include('header.php');
    include('../back/getCitas.php');
   
    if($result->rowCount() == 0){
        
        echo "<h2>¿Todavía no tienes citas?</h2>";
        echo "<button id='pedirCita'>Pide cita</button>";
    }else{
        $citas = $result->fetchAll();
        $citasJSON = json_encode($citas);
?>
<body>
    <div id="contenedor">
        <h1>Citas</h1>
        <div id="citas" class="">
            <table id="tablaCitas" class="table">
            <tr><td>Día</td><td>Hora</td><td>Paciente</td><td>Logopeda</td></tr>
            </table>
            <button id='pedirCita' class="btn">Pide cita</button>
            <?php } ?>
        
        <div id="formulario">
        </div>
        <div id="overlay"></div>
        </div>
    </div>
    <script>
        let citas
        try{
            citas = JSON.parse('<?php if(isset($citasJSON)){echo $citasJSON;} ?>');
        }catch(error){
            console.log(error);
        }


    </script>
</body>

