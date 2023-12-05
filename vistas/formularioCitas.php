
<?php 
session_start();
include('../modelo/functional.php');
comprobarLogin();
include('../modelo/bd.php');
$Crud = new Crud();
if($_SESSION['trabajador'] === true){
    $result = $Crud->ejecutarConsulta("SELECT id, nombre, apellidos FROM user WHERE trabajador = 'false'");
    $peticion = "Paciente";
}else{
    $result = $Crud->ejecutarConsulta("SELECT id, nombre, apellidos FROM user WHERE trabajador = 'true'");
    $peticion = "Logopeda";
}
$users = $result->fetchAll();
$horasres = $Crud->ejecutarConsulta("SELECT hora FROM citas_posibles");
$horas = $horasres->fetchAll();
$arrayHoras =  json_encode($horas);
?>
<script type="text/javascript" src="../scripts/jquery.formularioCitas.js"></script>
<form action='#'>
    <h3>Pedir cita</h3>
    <label for='peticion'><?=$peticion?></label>
    <select name='peticion' id='peticion'>
        <option value="0" style="display:none">Selecciona una <?=$peticion?></option>
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
        // Detectar cambios en el campo de fecha
        let horas = <?php echo $arrayHoras; ?>;
        let peticion = "<?php echo $peticion;?>";
        let trabajador, paciente;

        if (peticion == "Paciente") {
            trabajador = <?php echo $_SESSION['user_id'];?>;
        } else {
            paciente = <?php echo $_SESSION['user_id'];?>;
        }

</script>