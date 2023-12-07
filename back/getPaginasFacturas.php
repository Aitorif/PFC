<?php

if($_SESSION['rol'] == "admin"){
    $result = $Crud->ejecutarConsulta("SELECT COUNT(*) as total FROM facturas");
}else{
    $result = $Crud->ejecutarConsulta("SELECT COUNT(*) as total FROM facturas as f INNER JOIN user AS u ON f.id_user = u.id WHERE f.id_user = $user_id");
}
if($result != false){
    $total = $result->fetch()['total'];

}else{
    $total = 0;
}