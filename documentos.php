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
    $trabajador =$_SESSION['trabajador'];
    $trabajadorJSON = json_encode($_SESSION["trabajador"]);
    if($_SESSION['trabajador'] == true){
        $formShare = "formularioCompartir.php";
        $result = $Crud->ejecutarConsulta("SELECT COUNT(*) as total FROM documentos as d INNER JOIN trabajadores as t ON d.propietario = t.id WHERE d.propietario = $user_id");
        $total = $result->fetch()['total'];
    }else{
        $result = $Crud->ejecutarConsulta("SELECT COUNT(*) as total FROM documentos as d INNER JOIN documento_compartido as dc ON d.id = dc.id_documento INNER JOIN trabajadores AS t ON dc.id_trabajador = t.id WHERE dc.id_user = $user_id");
        $total = $result->fetch()['total'];
    }
    $entradasPorPagina = 10;
    $totalPaginas = ceil($total / $entradasPorPagina);
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
        $(document).ready(function() {
            var user_id = <?php echo $user_id; ?>;
            var checks = $('.check');
            let tabla = $('#tablaDocs');
            let titulo = $('#titleTable');
            let paginaActual = 1;
            let data = nuevaPagina(paginaActual);
            let trabajador = <?= $trabajadorJSON;?>;

            //Añadimos eventos a los numeros

            for(let i = 0; i < $('.numero').length; i++){
                $('.numero').eq(i).on("click", function(){
                    let pagina = $(this).text();
                    nuevaPagina(pagina)
                })
            }

            function actualizaTabla(data){
                tabla.html("");
                tabla.append(titulo);
                for(let i = 0; i < data.length; i++){
                    let nuevaFila = $("<tr></tr>");
                    nuevaFila.append("<td><input class='check' type='checkbox' value='"+data[i]['id']+"'/></td><td>"+data[i]['titulo']+"");
                    if(trabajador == true){
                        nuevaFila.append("<td>"+data[i]['ultima_modificacion']+"</td><td><a style='color: black;' href='http://localhost/clinica_castineira/editor.php?id_document="+data[i]['id']+"'>Editar</a></td>");
                    }
                    nuevaFila.append("<td><a style='color: black;' target='_blank' href='http://localhost/clinica_castineira/prevista.php?id_document="+data[i]['id']+"'>Imprimir</a></td>");
                    tabla.append(nuevaFila);
                }
            }

            function emailValidator(email) {
                // Expresión regular para validar un correo electrónico
                const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

                if (emailRegex.test(email)) {
                    return true;
                } else {
                    return false;
                }
            }
            function nuevaPagina(pagina){
                let indiceInicio = (pagina - 1) * 10;
                $.ajax({
                            type: "POST", 
                            url: "getDocumentos.php", 
                            data: {
                                indiceInicio: indiceInicio
                            },
                            success: function(response) {
                                try{
                                    let data = JSON.parse(response);
                                    actualizaTabla(data);
                                }catch(error){
                                    $('#documentos').html("<h2>Todavía no tienes ningún documento</h2>")
                                }
                                
                            }
                })
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
</body>