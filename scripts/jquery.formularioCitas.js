$(document).ready(function() {
    // Detectar cambios en el campo de fecha

    $("#peticion").change(function() {
        if (peticion == "Logopeda") {
            trabajador = $('select[name=peticion]').val();
        } else {
            paciente = $('select[name=peticion]').val();
        }
        $("#dia").val("");
    });

    $('#dia').on('input', function() {
        let dia = $(this).val();
        console.log(trabajador);
        console.log(paciente);
        if (dia && trabajador && paciente) {
            $.ajax({
                    url: '../back/citasPosibles.php',
                    type: 'POST',
                    data: {
                        dia:dia,
                        paciente:paciente,
                        trabajador:trabajador
                    },
                    success: function(response) {
                        let arrayCitas = JSON.parse(response);
                        
                        $("#horas").html("");
                        for(let i = 0; i < horas.length; i++){
                            let diferente = true;
                            for(let j= 0; j < arrayCitas.length; j++){  
                                if(horas[i]["hora"]==arrayCitas[j]['hora']){
                                    console.log(horas[i]["hora"] +"-"+arrayCitas[j]['hora'] )   
                                    diferente = false;
                                    break;
                                }
                            }

                            if(diferente == true){
                                // Añadir el elemento al contenido del div
                                $('#horas').append('<input type="radio"  id="hora'+i+'" name="hora" value="'+horas[i]["hora"]+'"><label class="labelHora" for="hora'+i+'">'+horas[i]["hora"]+'</label>');
                            }else{
                                $('#horas').append('<label class="labelHoraDes" for="hora'+i+'">'+horas[i]["hora"]+'</label>');
                            }
                            
                        }
                    },
                    error: function() {
                        console.error('Error al cargar el contenido');
                    }
                });
        
        }else{
        // Si no hay fecha seleccionada
        $('#resultado').text('No hay fecha seleccionada.');
        }
    });


    $("#guardarCita").on("click", function(){
        event.preventDefault();
        let diaFinal =  $("#dia").val();
        let hora = $('input:radio[name=hora]:checked').val();
        
        if(hora != undefined || hora != null){
            $.ajax({
                    url: '../back/guardarCita.php',
                    type: 'POST',
                    data: {
                        dia:diaFinal,
                        hora: hora,
                        paciente: paciente,
                        trabajador: trabajador
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(error) {
                        console.error(error);
                    }
            });
            
        }else{
            alert("Debes de seleccionar día, hora y paciente");
        }
    });

    
})