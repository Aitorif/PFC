$(document).ready(function() {
    $("#peticion").change(function() {
        cliente = $('select[name=peticion]').val();
        $.ajax({
            url: '../back/getDatosCliente.php',
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
        url: "../back/guardarFactura.php",
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