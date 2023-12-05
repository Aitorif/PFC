<?php
include('../modelo/bd.php');
    $Crud = new Crud();
    $user_id = $_SESSION['user_id'];
    $trabajador = $_SESSION['trabajador'];
    if($trabajador == true && $_SESSION['rol'] != "admin"){
        $result = $Crud->ejecutarConsulta("SELECT c.dia, c.hora, u.nombre as nombre_paciente, u.nombre as nombre_trabajador, c.id
        FROM citas as c
        INNER JOIN user as t ON c.id_trabajador = t.id
        INNER JOIN user as u ON c.id_paciente = u.id
        WHERE id_trabajador = $user_id
        ORDER BY c.dia, SUBSTRING(c.hora, 1, 2), SUBSTRING(c.hora, 4, 5) DESC");
        
    }else if($trabajador == true && $_SESSION['rol'] == "admin"){
        $result = $Crud->ejecutarConsulta("SELECT c.dia, c.hora, u.nombre as nombre_paciente, t.nombre as nombre_trabajador, c.id
        FROM citas as c
        INNER JOIN user as t ON c.id_trabajador = t.id
        INNER JOIN user as u ON c.id_paciente = u.id
        ORDER BY c.dia, SUBSTRING(c.hora, 1, 2), SUBSTRING(c.hora, 4, 5) DESC");
    
    }else{
        $result = $Crud->ejecutarConsulta("SELECT c.dia, c.hora, u.nombre as nombre_paciente, t.nombre as nombre_trabajador, c.id
        FROM citas as c
        INNER JOIN user as t ON c.id_trabajador = t.id
        INNER JOIN user as u ON c.id_paciente = u.id
        WHERE id_paciente = $user_id
        ORDER BY c.dia, c.hora");
    }