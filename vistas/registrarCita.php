<?php
session_start();

if(!isset($_COOKIE["login"]) || $_COOKIE["login"] != "loged"){
    header('Location: ../index.php');
    exit();
}
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
   
    <title>Clínica Logopédica Castiñeira</title>
</head>
<?php 
    include('header.php');
    include('../modelo/bd.php');
    $Crud = new Crud();
    $user_id = $_SESSION['user_id'];
    $trabajador = $_SESSION['trabajador'];
    if($trabajador == true && $_SESSION['rol'] != "admin"){
        $result = $Crud->ejecutarConsulta("SELECT c.dia, c.hora, u.nombre as nombre_paciente, t.nombre as nombre_trabajador, c.id
        FROM citas as c
        INNER JOIN trabajadores as t ON c.id_trabajador = t.id
        INNER JOIN user as u ON c.id_paciente = u.id
        WHERE id_trabajador = $user_id
        ORDER BY c.dia, SUBSTRING(c.hora, 1, 2), SUBSTRING(c.hora, 4, 5) DESC");
        
    }else if($trabajador == true && $_SESSION['rol'] == "admin"){
        $result = $Crud->ejecutarConsulta("SELECT c.dia, c.hora, u.nombre as nombre_paciente, t.nombre as nombre_trabajador, c.id
        FROM citas as c
        INNER JOIN trabajadores as t ON c.id_trabajador = t.id
        INNER JOIN user as u ON c.id_paciente = u.id
        ORDER BY c.dia, SUBSTRING(c.hora, 1, 2), SUBSTRING(c.hora, 4, 5) DESC");
    
    }else{
        $result = $Crud->ejecutarConsulta("SELECT c.dia, c.hora, u.nombre as nombre_paciente, t.nombre as nombre_trabajador, c.id
        FROM citas as c
        INNER JOIN trabajadores as t ON c.id_trabajador = t.id
        INNER JOIN user as u ON c.id_paciente = u.id
        WHERE id_paciente = $user_id
        ORDER BY c.dia, c.hora");
    }
   
    if($result->rowCount() == 0){
        
        echo "<h2>¿Todavía no tienes citas?</h2>";
        echo "<button id='pedirCita'>Pide cita</button>";
    }else{
        $citas = $result->fetchAll();
        $citasJSON = json_encode($citas);
?>
<body>
    <div id="contenedor">
        <div id="citas" class="">
            <table id="tablaCitas">
            <tr><td>Día</td><td>Hora</td><td>Paciente</td><td>Logopeda</td></tr>
            </table>
            <button id='pedirCita'>Pide cita</button>
            <?php } ?>
        
        <div id="formulario">
        
        </div>

        </div>
    </div>
    <script>
        $(document).ready(function(){
            let boton = $('#pedirCita');
            let divForm = $('#formulario');
            let tablaCitas = $('#tablaCitas');
            try{
                let citas = JSON.parse('<?php if(isset($citasJSON)){echo $citasJSON;} ?>');
                for(let i = 0; i < citas.length; i++){
                tablaCitas.append("<tr><td>"+citas[i]['dia']+"</td><td>"+citas[i]['hora']+"</td><td>"+citas[i]['nombre_paciente']+"</td><td>"+citas[i]['nombre_trabajador']+"</td><td> <button class='cancelarCita' id-target='"+citas[i]['id']+"'>Anular cita</button><td></tr>");
            }
            }catch(error){
                console.log(error);
            }

            let filterDia = $('filterDia');
            let filterHora = $('filterHora');
            let filterPaciente = $('filterPaciente');



            $("#pedirCita").on("click", function(){
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

            for(let i = 0; i < $('.cancelarCita').length; i++){
                $('.cancelarCita').eq(i).on("click", function(){
                    console.log("asdasd");
                    let cita = $(this).attr('id-target');
                    let confirmacion = confirm("¿Estás seguro de que quieres borrar la cita seleccionada?");
                    if(confirmacion == true){
                        $.ajax({
                            type: "POST", 
                            url: "../back/borrarCita.php", 
                            data: {
                                cita: cita
                            },
                            success: function(response) {
                                console.log(response);
                                window.location.reload();
                            }
                        })
                    }
                });
            }

        });
    </script>
</body>

