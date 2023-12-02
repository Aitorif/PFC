<?php
session_start();

if(!isset($_COOKIE["login"]) || $_COOKIE["login"] != "loged" || $_SESSION['trabajador'] != true){
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
    <link rel="stylesheet" href="./Rich-Text-Editor-jQuery-RichText/src/richtext.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="./Rich-Text-Editor-jQuery-RichText/src/jquery.richtext.js"></script>
    <title>Clínica Logopédica Castiñeira</title>
</head>
<body>
<?php
    include('header.php');
    include('bd.php');
    $Crud = new Crud();

    $result = $Crud->ejecutarConsulta("SELECT id, nombre, apellidos FROM user");
    $users = $result->fetchAll();
?>
    <div id="contenedor">
    <h1>Factura</h1>
    <select name='peticion' id='peticion'>
        <option value="0" style="display:none">Selecciona una paciente para autocompletar</option>
        <?php foreach($users as $user){
            echo "<option value='".$user['id']."'>".$user['nombre']." ".$user['apellidos']."</option>";
        }?>
    </select>
    <form id="formfactura" action="plantillaFactura.php" method="post" style="max-width: 100px" >
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
    <h2>Detalle de la Factura</h2>
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

<script>
 $(document).ready(function() {
    $("#peticion").change(function() {
        cliente = $('select[name=peticion]').val();
        $.ajax({
            url: 'getDatosCliente.php',
            type: 'GET',
            data: {
                cliente:cliente
            },
            success: function(response) {
                let data = JSON.parse(response);
                $("#nombre").val(data[0].nombre);
                $("#apellidos").val(data[0].apellidos);
                $("#direccion").val(data[0].direccion);
                $("#dni").val(data[0].dni);

            },
            error: function() {
                console.error('Error al cargar el contenido');
            }
        });
    });

    $("#formfactura").on("submit", function() {
        event.preventDefault();
        cliente = $('select[name=peticion]').val();
        let fecha = $("input[name='fecha']").val();
        let descripcion = $("input[name='descripcion']").val();
        let cantidad = $("input[name='cantidad']").val();
        let precioUnitario = $("input[name='precio']").val();
        let total = $("input[name='total_factura']").val();

        $.ajax({
        url: "guardarFactura.php",
        type: "POST",
        data:{
            cliente:cliente,
            fecha: fecha,
            descripcion: descripcion,
            cantidad: cantidad,
            precio: precioUnitario,
            total: total
        },
        success: function(response) {
            alert("Se ha guardado la factura correctamente");
            console.log(response);
            $(location).attr('href',"previstaFactura.php?id_factura="+response);
        },
        error: function(error) {

            alert("Error en la solicitud AJAX:", error);
        }
        });
    });



 });
</script>