<?php
session_start();

if(!isset($_COOKIE["login"]) || $_COOKIE["login"] != "loged"){
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/editor.css">

    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="Rich-Text-Editor-jQuery-RichText/src/richtext.min.css">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
-->  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="./Rich-Text-Editor-jQuery-RichText/src/jquery.richtext.min.js"></script>
    <title>Clínica Logopédica Castiñeira</title>
</head>
<?php 
    include('header.php');
    include('bd.php');
    $Crud = new Crud();
    $user_id = $_SESSION['user_id'];
    $trabajador = $_SESSION['trabajador'];
    if($trabajador == true){
        $formShare = "formularioCompartir.php";
        $result = $Crud->ejecutarConsulta("SELECT d.id, d.titulo, d.ultima_modificacion, t.nombre FROM documentos as d INNER JOIN trabajadores as t ON d.propietario = t.id WHERE d.propietario = $user_id");
    }else{
        $result = $Crud->ejecutarConsulta("SELECT d.id, d.titulo, t.nombre FROM documentos as d INNER JOIN documento_compartido as dc ON d.id = dc.id_documento INNER JOIN trabajadores AS t ON dc.id_trabajador = t.id WHERE dc.id_user = $user_id");
    }
   
    if($result->rowCount() == 0){
        
        echo "<h2>Todavía no tienes documentos</h2>";
    }else{
        $documentos = $result->fetchAll();
    


?>
<body>
    <div id="contenedor">
        <div id="documentos" class="">
            <form method="post">
            <table>
                <tr><td><input id="selTodo" type='checkbox' value=""/>
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
                </td>
                
                <td>Título</td><?php if($trabajador == true){echo"<td>Últ. modificacion</td>";}?></tr>
                
            <?php

                foreach($documentos as $elementos){
                    echo "<tr><td><label><input class='check' type='checkbox' value='".$elementos['id']."'/>".$elementos['titulo']."</label>";
                    if($trabajador == true){
                        echo "</td><td>".$elementos['ultima_modificacion']."</td><td><a style='color: black;' href='http://localhost/clinica_castineira/editor.php?id_document=".$elementos['id']."'>Editar</a></td>";
                    }
                    echo "<td><a style='color: black;' target='_blank' href='http://localhost/clinica_castineira/prevista.php?id_document=".$elementos['id']."'>Imprimir</a></td></tr>";
                }

            ?>
            </table>
            <div id="compartirDoc">
                <label>Email de destino<input type="email" id="email" name="email" required></label>
            </div>
                <input type="button" id="borrar" value="Borrar">
                <input type="button" id="compartir" value="Compartir">
            </form>
            <p id="error"></p>
        </div>

    </div>
    
   <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
            -->
        <script>
            $(document).ready(function() {
                var user_id = <?php echo $user_id; ?>;
                var checks = $('.check');

                function emailValidator(email) {
                    // Expresión regular para validar un correo electrónico
                    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

                    if (emailRegex.test(email)) {
                        return true;
                    } else {
                        return false;
                    }
                }

                $('#selTodo').on('click',function(){
                    
                    if($('#selTodo')[0].checked == true){
                        for (let i=0; i < checks.length; i++) {
                            checks[i].checked = true;
                        }
                    }else{
                        for (let i=0; i < checks.length; i++) {
                            checks[i].checked = false;
                        }
                    }
                    
                })

                $('#borrar').on('click', function(){
                    
                    var arraydoc_id = []
                    for (let i=0; i < checks.length; i++) {
                        if(checks[i].checked == true){
                            arraydoc_id.push(checks[i].value);
                        }
                    }
                    if(arraydoc_id.length > 0){
                        var confirmacion = confirm("¿Estás seguro de que quieres borrar los documentos seleccionados?");
                        if(confirmacion == true){
                            $.ajax({
                                type: "POST", 
                                url: "borrarDocumento.php", 
                                data: {
                                    arraydoc_id: arraydoc_id,
                                    userid: user_id
                                },
                                success: function(response) {
                                    console.log(response);
                                    window.location.reload();
                                }
                            })
                        }
                    }
                })


                $('#compartir').on('click', function(){
                    var email = $('#email').val();
                    var validEmail = emailValidator(email);
                    var arraydoc_id = []
                    for (let i=0; i < checks.length; i++) {
                        if(checks[i].checked == true){
                            arraydoc_id.push(checks[i].value);
                        }
                    }
                    console.log(arraydoc_id);
                    if(arraydoc_id.length > 0 && validEmail === true){
                        var confirmacion = confirm("¿Estás seguro de que quieres compartir los documentos seleccionados con "+email+"?");
                        if(confirmacion == true){
                            $.ajax({
                                type: "POST", 
                                url: "compartirDocumento.php", 
                                data: {
                                    arraydoc_id: arraydoc_id,
                                    email: email, 
                                    user_id: user_id
                                },
                                success: function(response) {
                                    console.log(response);
                                    window.location.reload();
                                },
                                error: function(jqXHR){
                                    console.log(jqXHR.responseText);
                                }
                            })
                        }
                    }else if(!validEmail){
                        alert("Debes introducir un email válido");
                    }else{
                        alert("No has seleccionado ningún documento para compartir");
                    }
                })

                $('#selector').change(function() {
                    if ($(this).val() === 'compartir') {
                        $('#compartirDoc').show();
                        $('#compartir').show();
                        $('#borrar').hide();
                    } else if($(this).val() === 'borrar'){
                        $('#compartirDoc').hide();
                        $('#compartir').hide();
                        $('#borrar').show();
                    }else{
                        $('#compartirDoc').hide();
                        $('#compartir').hide();
                        $('#borrar').hide();
                    }
                });
            });
        </script>
        <?php }?>
</body>