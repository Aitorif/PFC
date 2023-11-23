
<?php 
session_start();
if(!isset($_COOKIE["login"]) || $_COOKIE["login"] != "loged"){
    header('Location: index.php');
    exit();
}
include('bd.php');
$Crud = new Crud();
$result = $Crud->ejecutarConsulta("SELECT id, nombre, apellidos FROM user");
$users = $result->fetchAll();
$horasres = $Crud->ejecutarConsulta("SELECT hora FROM citas_posibles");
$horas = $horasres->fetchAll();
$arrayHoras =  json_encode($horas);
?>
<form action='#'>
    <h3>Pedir cita</h3>
    <label for='paciente'>Paciente</label>
    <select name='paciente' id='paciente'>
        <?php foreach($users as $user){
            echo "<option value='".$user['id']."'>".$user['nombre']." ".$user['apellidos']."</option>";
        }?>
    </select>
    <label for="dia">Dia</label>
    <input type="date" id="dia" name="dia" min="<?php echo date("Y-m-d"); ?>" required/>
    <label for="hora">Hora</label>
    <div id="horas"></div>
    <button id="guardarCita">Guardar cita</button>
</form>

<script>
    $(document).ready(function() {
        // Detectar cambios en el campo de fecha
        var horas = <?php echo $arrayHoras; ?>;
        let trabajador = <?php echo $_SESSION['user_id']?>;
        $('#dia').on('input', function() {
            let dia = $(this).val();

            if (dia) {
                $.ajax({
                        url: 'citasPosibles.php',
                        type: 'POST',
                        data: {
                            dia:dia
                        },
                        success: function(response) {
                            let arrayCitas = JSON.parse(response)
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
            
            } else {
            // Si no hay fecha seleccionada
            $('#resultado').text('No hay fecha seleccionada.');
            }
        });

        $("#guardarCita").on("click", function(){
            event.preventDefault();
            let diaFinal =  $("#dia").val();
            let hora = $('input:radio[name=hora]:checked').val();
            let paciente = $('select[name=paciente]').val()
            if(hora != undefined || hora != null){
                $.ajax({
                        url: 'guardarCita.php',
                        type: 'POST',
                        data: {
                            dia:diaFinal,
                            hora: hora,
                            paciente: paciente,
                            trabajador: trabajador
                        },
                        success: function(response) {
                            console.log(response);
                            window.location.reload();
                        },
                        error: function() {
                            console.error('Error al cargar el contenido');
                        }
                });
                
            }else{
                alert("Debes de seleccionar día, hora y paciente");
            }
            

        });
    })
</script>