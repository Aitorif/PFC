<?php
session_start();

if(!isset($_COOKIE["login"]) || $_COOKIE["login"] != "loged" || $_SESSION['rol']!="admin"){
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
    $resultTrabajadores = $Crud->ejecutarConsulta("SELECT id, nombre, apellidos, dni, telefono, email, rol
    FROM trabajadores
    ORDER BY nombre, apellidos DESC");

    $resultUsuarios = $Crud->ejecutarConsulta("SELECT id, nombre, apellidos, email
    FROM user
    ORDER BY nombre, apellidos DESC");
    if($resultTrabajadores->rowCount() == 0 & $resultUsuarios->rowCount() == 0){
        
    }else{
        $usuarios = $resultUsuarios->fetchAll();
        $usuariosJSON = json_encode($usuarios);
        $trabajadores = $resultTrabajadores->fetchAll();
        $trabajadoresJSON = json_encode($trabajadores);
?>
<body>
    <div id="contenedor">
        <div id="citas" class="">
            <select name="selector" id="selector">
            <option value="" style="display:none">Selecciona un tipo de usuario</option>
                <option value="trabajadores">Trabajadores</option>
                <option value="usuarios">Pacientes</option>
            </select>
            <table id="tablaCitas" class="table">

            </table>
            <?php } ?>

            <button id="crear">Crear usuario</button>
            <div id="nuevoUsuario"></div>
        </div>
    </div>


<script>
    $(document).ready(function() {
        let trabajadores = '<?php echo $trabajadoresJSON; ?>';
        let usuarios = '<?php echo $usuariosJSON; ?>';
        let trabajadoresJSON = JSON.parse(trabajadores);
        let usuariosJSON = JSON.parse(usuarios);
        let tablaCitas = $("#tablaCitas");
        let tableHeaderUsuarios = "<tr><td>ID</td><td>Nombre</td><td>Apellidos</td><td>Email</td></tr>";
        let tableHeaderTrabajadores = "<tr><td>ID</td><td>Nombre</td><td>Apellidos</td><td>Email</td><td>DNI</td><td>Teléfono</td><td>Especialidad</td><td>Rol</td></tr>";
        let data;   

        $("#crear").on("click", function(){
            $.ajax({
                    url: 'nuevoUsuarioAdmin.php',
                    type: 'GET',
                    success: function(response) {
                        // Actualizar el contenido del div con la respuesta del archivo PHP
                        $("#nuevoUsuario").html(response);
                    },
                    error: function() {
                        console.error('Error al cargar el contenido');
                    }
                 });
        });
        
        $("#selector").change(function() {
            let opcion = $('select[name=selector]').val();
            tablaCitas.html("");
            if (opcion == "usuarios") {
                data = usuariosJSON;
                tablaCitas.append(tableHeaderUsuarios);
            } else {
                data = trabajadoresJSON;
                tablaCitas.append(tableHeaderTrabajadores);
            }
            for(let i = 0; i < data.length; i++){
                let nuevaFila = $("<tr></tr>");
                for(let j = 0; j < (Object.keys(data[i]).length/2); j++){
                    nuevaFila.append("<td>"+data[i][j]+"</td>");
                }
                nuevaFila.append("<td><button id='cancelarCita' id-target='"+data[i][0]+"'>Borrar usuario</button></td>")
                tablaCitas.append(nuevaFila);
            }
        });
    });
</script>