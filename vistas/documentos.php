<?php
session_start();

include('../modelo/functional.php');
comprobarLogin();
include('../modelo/bd.php');
$Crud = new Crud();
$user_id = $_SESSION['user_id'];
$trabajador =$_SESSION['trabajador'];
$trabajadorJSON = json_encode($_SESSION["trabajador"]);
if($_SESSION['trabajador'] == true){
    $formShare = "formularioCompartir.php";
    $result = $Crud->ejecutarConsulta("SELECT COUNT(*) as total FROM documentos as d INNER JOIN user as t ON d.propietario = t.id WHERE d.propietario = $user_id");
    $total = $result->fetch()['total'];
}else{
    $result = $Crud->ejecutarConsulta("SELECT COUNT(*) as total FROM documentos as d INNER JOIN documento_compartido as dc ON d.id = dc.id_documento INNER JOIN user AS t ON dc.id_trabajador = t.id WHERE dc.id_user = $user_id");
    $total = $result->fetch()['total'];
}
$entradasPorPagina = 10;
$totalPaginas = ceil($total / $entradasPorPagina);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/editor.css">

    <link rel="stylesheet" href="../estilos/estilos.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../Rich-Text-Editor-jQuery-RichText/src/richtext.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="../Rich-Text-Editor-jQuery-RichText/src/jquery.richtext.js"></script>
    <script  type="text/javascript" src="../scripts/jquery.documentos.js"></script>
    <title>Clínica Logopédica Castiñeira</title>
</head>
<?php 
include('header.php');
?>
<body>
    <div id="contenedor">
    <h1>Mis documentos</h1>
        <div id="documentos" class="">

            <form method="post">
            <?php if($trabajador == true){
                echo "<div id='buttons'><a href='editor.php' class='docButton btn'>Nuevo documento</a>";
                    if($_SESSION["rol"]=="admin"){ echo "<a class='docButton btn' href='plantillaFactura.php'>Nueva factura</a></div>";}
                ;
            }?>
            <table id="tablaDocs" class="table">
                <tr id="titleTable"><th><div id="options"><input id="selTodo" type='checkbox' value=""/>
                <?php
                if($trabajador == true){
                    echo "
                        <select id='selector'>
                        <option value='selecciona'>Selecciona...</option>
                        <option value='compartir'>Compartir</option>
                        <option value='borrar'>Borrar</option>
                        </select>
                    ";
                }
                ?>
                </div>
                </th>
                <th >Título</th><?php if($trabajador == true){echo"<th>Últ. modificacion</th>";}?><th></th><th></th></tr>
            </table>
            <div id="compartirDoc">
                <label>Email de destino<input type="email" id="email" name="email" required></label>
            </div>
                <input type="button" id="borrar" value="Borrar">
                <input type="button" id="compartir" value="Compartir">
            </form>
            <div id="numeros">
                <?php
                    for($i = 1; $i <= $totalPaginas; $i++){
                        echo "<a class='numero' style='color:#3498db; cursor: pointer'>$i</a>";
                    }

                ?>

            </div>
            <p id="error"></p>
        </div>

    </div>
    
    <script>
        let user_id = <?php echo $user_id; ?>;
        let trabajador = <?= $trabajadorJSON;?>;
        console.log(trabajador);
    </script>
</body>