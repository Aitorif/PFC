$(document).ready(function() {
    let trabajadoresJSON;
    let usuariosJSON;
    try{
        trabajadoresJSON = JSON.parse(trabajadores);
        usuariosJSON = JSON.parse(usuarios);
    }catch(error){

    }
    let tablaCitas = $("#tablaCitas");
    let tableHeaderUsuarios = "<tr><td>ID</td><td>Nombre</td><td>Apellidos</td><td>Email</td></tr>";
    let tableHeaderTrabajadores = "<tr><td>ID</td><td>Nombre</td><td>Apellidos</td><td>Email</td><td>DNI</td><td>Teléfono</td><td>Rol</td></tr>";
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