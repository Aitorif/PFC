<?php
include('bd.php');
$Crud = new Crud();
$dia = $_POST['dia'];
$resultado = $Crud->ejecutarConsulta("SELECT cp.hora FROM citas_posibles as cp INNER JOIN citas as c ON cp.hora = c.hora WHERE c.dia = '$dia'");
$citas = $resultado->fetchAll();
$arrayCitas =json_encode($citas);
echo $arrayCitas;