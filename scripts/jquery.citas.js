    $(document).ready(function(){
            let boton = $('#pedirCita');
            let divForm = $('#formulario');
            let tablaCitas = $('#tablaCitas');

            for(let i = 0; i < citas.length; i++){
                tablaCitas.append("<tr><td>"+citas[i]['dia']+"</td><td>"+citas[i]['hora']+"</td><td>"+citas[i]['nombre_paciente']+"</td><td>"+citas[i]['nombre_trabajador']+"</td><td> <button class='cancelarCita' id-target='"+citas[i]['id']+"'>Anular cita</button><td></tr>");
            }

            function salirFormulario(){
                $("#overlay").toggle();
                divForm.html("");
                divForm.removeClass("formularioActivo");
            }

            boton.on("click", function(){
                let salir = $('<button>', {
                    text: 'x',
                    click: salirFormulario,
                    class: "salir btn",
                    id: "salir"
                });
                $.ajax({
                    url: 'formularioCitas.php',
                    type: 'GET',
                    success: function(response) {
                        // Actualizar el contenido del div con la respuesta del archivo PHP
                        divForm.html(response);
                        divForm.prepend(salir);
                    },
                    error: function() {
                        console.error('Error al cargar el contenido');
                    }
                 });
                 divForm.addClass('formularioActivo');
                 $("#overlay").toggle();
            });


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