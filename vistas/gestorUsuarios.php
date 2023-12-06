<?php
session_start();

include('../modelo/functional.php');
comprobarLogin();
comprobarTrabajador();
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
    <script type="text/javascript" src="../scripts/jquery.gestorUsuarios.js"></script>
    <title>Clínica Logopédica Castiñeira</title>
</head>
<?php 
    include('header.php');
    include('../modelo/bd.php');
    $Crud = new Crud();
    $user_id = $_SESSION['user_id'];
    $resultTrabajadores = $Crud->ejecutarConsulta("SELECT id, nombre, apellidos, dni, telefono, email, rol
    FROM user WHERE trabajador = 'true'
    ORDER BY nombre, apellidos DESC");

    $resultUsuarios = $Crud->ejecutarConsulta("SELECT id, nombre, apellidos, email
    FROM user WHERE trabajador = 'false'
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

            <button id="crear" class="btn">Crear usuario</button>
            <div id="nuevoUsuario"></div>
        </div>
    </div>


<script>
    let id = '<?php echo $_SESSION['user_id']; ?>'
    let trabajadores = '<?php echo $trabajadoresJSON; ?>';
    let usuarios = '<?php echo $usuariosJSON; ?>';
</script>