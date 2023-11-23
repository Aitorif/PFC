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

    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="Rich-Text-Editor-jQuery-RichText/src/richtext.min.css">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
-->  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="./Rich-Text-Editor-jQuery-RichText/src/jquery.richtext.min.js"></script>
    <title>Clínica Logopédica Castiñeira</title>
</head>
<?php 
    include('header.php');
    include('bd.php');
    $Crud = new Crud();
    $user_id = $_SESSION['user_id'];
    $trabajador = $_SESSION['trabajador'];
    if($trabajador == true){
        $result = $Crud->ejecutarConsulta("SELECT c.dia, c.hora, u.nombre, t.nombre FROM citas as c INNER JOIN trabajadores as t ON c.id_trabajador = t.id INNER JOIN user as u ON c.id_paciente = u.id WHERE id_trabajador = $user_id");
    }else{
        $result = $Crud->ejecutarConsulta("SELECT c.dia, c.hora, u.nombre, t.nombre FROM citas as c INNER JOIN trabajadores as t ON c.id_trabajador = t.id INNER JOIN user as u ON c.id_paciente = u.id WHERE id_paciente = $user_id");
    }
   
    if($result->rowCount() == 0){
        
        echo "<h2>¿Todavía no tienes citas?</h2>";
        echo "<button id='pedirCita'>Pide cita</button>";
    }else{
        $citas = $result->fetchAll();

?>
<body>
    <div id="contenedor">
        <div id="citas" class="">
            <table>
            <tr><td>Día</td><td>Hora</td><td>Logopeda</td><td>Paciente</td></tr>
            <?php
    
            foreach($citas as $cita){
                echo "<tr><td>".$cita[0]."</td><td>".$cita[1]."</td><td>".$cita[2]."</td><td>".$cita[3]."</td></tr>";
            }

            ?>
            </table>
            <button id='pedirCita'>Pide cita</button>
        <div id="formulario">
        
        </div>

        </div>
    </div>
    <script>
        $(document).ready(function(){
            let boton = $('#pedirCita');
            let divForm = $('#formulario');
            boton.on("click", function(){
                $.ajax({
                    url: 'formularioCitas.php',
                    type: 'GET',
                    success: function(response) {
                        // Actualizar el contenido del div con la respuesta del archivo PHP
                        divForm.html(response);
                    },
                    error: function() {
                        console.error('Error al cargar el contenido');
                    }
                 });
                 divForm.addClass('formularioActivo');
            })
        })
    </script>
</body>

<?php } ?>