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
    let idCambio = {};
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

    function actualizarUsuarios(){
        if(Object.keys(idCambio)== 0){
            alert("No has cambiado ningún parámetro de los usuarios");
        }else{

            $.ajax({
                type: "POST", 
                url: "../back/actualizarUsuario.php", 
                data: { datos: JSON.stringify(idCambio), inputAdmin: true },
                success: function(response) {
                        alert(response); 
                        window.location.reload();
                }
            });
        }
    }

    function borrarUsuario(){
        let id = $(this).attr("id");
        $.ajax({
            type: "POST", 
            url: "../back/borrarUsuario.php", 
            data: { id:id },
            success: function(response) {
                    alert(response); 
                    window.location.reload();
            }
        });
    }
    
    $("#selector").change(function() {
        let opcion = $('select[name=selector]').val();
        tablaCitas.html("");
        let nuevoBoton = $('<button>', {
            text: 'Actualizar Usuarios',
            click: actualizarUsuarios,
            class: "btn"
        });
        if (opcion == "usuarios") {
            data = usuariosJSON;
            tablaCitas.append(tableHeaderUsuarios);
            
        } else {
            data = trabajadoresJSON;
            tablaCitas.append(nuevoBoton);
            tablaCitas.append(tableHeaderTrabajadores);
        }
        for(let i = 0; i < data.length; i++){
            let nuevaFila = $("<tr></tr>");
            for(let j = 0; j < (Object.keys(data[i]).length/2); j++){
                if(j == 6 && data[i]["id"] != id){
                    let otraOpcion = (data[i][j] === 'admin') ? 'user' : 'admin';
                    nuevaFila.append("<td><select id='rolSelect"+data[i]['id']+"' id-target = "+data[i]['id']+"><option val='"+data[i][j]+"'>"+data[i][j]+"</option><option val='"+otraOpcion+"'>"+otraOpcion+"</option><select></td>");
                }else{
                    nuevaFila.append("<td>"+data[i][j]+"</td>");
                }
                
            }
            let botonBorrar = $('<button>', {
                text: 'Borrar usuario',
                click: borrarUsuario,
                class: "btn",
                id: data[i]["id"]
            });
            if(data[i]["id"] != id){
                
                nuevaFila.append(botonBorrar);
            }

            nuevaFila.on('change', 'select', function() {
                let selectedValue = $(this).val();
                let id = $(this).attr('id-target');
                idCambio[id] = selectedValue;
            });
            tablaCitas.append(nuevaFila);
        }
    });


});