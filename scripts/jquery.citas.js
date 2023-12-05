    $(document).ready(function(){
            let boton = $('#pedirCita');
            let divForm = $('#formulario');
            let tablaCitas = $('#tablaCitas');

            for(let i = 0; i < citas.length; i++){
                tablaCitas.append("<tr><td>"+citas[i]['dia']+"</td><td>"+citas[i]['hora']+"</td><td>"+citas[i]['nombre_paciente']+"</td><td>"+citas[i]['nombre_trabajador']+"</td><td> <button class='cancelarCita' id-target='"+citas[i]['id']+"'>Anular cita</button><td></tr>");
            }


            let filterDia = $('filterDia');
            let filterHora = $('filterHora');
            let filterPaciente = $('filterPaciente');



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