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
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="../scripts/jquery.plantillaFactura.js"></script>
  <title>Clínica Logopédica Castiñeira</title>
</head>
<body>
<?php
    include('header.php');
    include('../modelo/bd.php');
    $Crud = new Crud();

    $result = $Crud->ejecutarConsulta("SELECT id, nombre, apellidos FROM user WHERE trabajador = 'false'");
    $users = $result->fetchAll();
?>
    <div id="contenedorFacturas">
    <h1>Factura</h1>
    <select name='peticion' id='peticion'>
        <option value="0" style="display:none">Selecciona una paciente para autocompletar</option>
        <?php foreach($users as $user){
            echo "<option value='".$user['id']."'>".$user['nombre']." ".$user['apellidos']."</option>";
        }?>
    </select>
    <form id="formfactura" action="plantillaFactura.php" method="post" style="width: 100%" >
    <table style="max-width: 100%" id="formfactura">
        <tr>
            <td>Nombre del Cliente:  <input type="text" name="nombre" id="nombre" required></td>
            <td>Apellidos del Cliente:<input type="text" name="apellidos" id="apellidos" required></td>
        </tr>

        <tr>
            <td>Dirección del Cliente:  <input type="text" name="direccion_cliente" id="direccion" required></td>
            <td>DNI del Cliente:  <input type="text" name="nombre" id="dni" required></td>    
        </tr>
        <tr>
            <td>Fecha: <input type="date" name="fecha" required id="fecha"></td>
        </tr>
    </table>
    <h2 style="width: 100%">Detalle de la Factura</h2>
    <table style="max-width:600px" border="1">
        <tr>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
        </tr>
        <tr>
            <td><input type="text" name="descripcion" required></td>
            <td><input type="number" name="cantidad" required></td>
            <td><input type="number" name="precio" placeholder="€" required></td>
        </tr>
        <!-- Puedes agregar más filas de productos aquí -->
    </table>
    <h3>Total de la Factura: <input type="number" name="total_factura" placeholder="€" required></h3>
    <input type="submit" id="enviar" name="Enviar" class="btn">
    </form>

    
</div>
</body>
