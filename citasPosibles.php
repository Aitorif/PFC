<?php
include('bd.php');
$Crud = new Crud();
$dia = $_POST['dia'];
$trabajador = $_POST['trabajador'];
$paciente = $_POST['paciente'];
$resultado = $Crud->ejecutarConsulta("SELECT cp.hora FROM citas_posibles as cp INNER JOIN citas as c ON cp.hora = c.hora WHERE c.dia = '$dia' AND (c.id_trabajador = '$trabajador' OR c.id_paciente = '$paciente')");
$citas = $resultado->fetchAll();
$arrayCitas =json_encode($citas);
echo $arrayCitas;