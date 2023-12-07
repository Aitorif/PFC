$(document).ready(function() {
    
    let checks;
    let tabla = $('#tablaDocs');
    let titulo = $('#titleTable');
    let paginaActual = 1;
    let data = nuevaPagina(paginaActual);

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
                nuevaFila.append("<td>"+data[i]['ultima_modificacion']+"</td><td><a style='color: black;' href='http://localhost/clinica_castineira/vistas/editor.php?id_document="+data[i]['id']+"'>Editar</a></td>");
            }
            nuevaFila.append("<td><a style='color: black;' target='_blank' href='http://localhost/clinica_castineira/vistas/prevista.php?id_document="+data[i]['id']+"'>Imprimir</a></td>");
            tabla.append(nuevaFila);
        }
        checks = $('.check');
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
        console.log(indiceInicio)
        $.ajax({
                    type: "GET", 
                    url: "../back/getDocumentos.php", 
                    data: {
                        indiceInicio: indiceInicio
                    },
                    success: function(response) {
                        try{
                            let data = JSON.parse(response);
                            actualizaTabla(data);
                        }catch(error){
                            $('#documentos').html("<h2>Todavía no tienes ningún documento</h2>")
                            console.log(response);
                        }
                    }
        })
    }

    $(document).on('change', '#selector', function() {
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
   
//    $("#selector").change(function() {
//         console.log($('#selector').val());
//         if ($(this).val() === 'compartir') {
            
//             $('#compartirDoc').show();
//             $('#compartir').show();
//             $('#borrar').hide();
//         } else if($(this).val() === 'borrar'){
//             $('#compartirDoc').hide();
//             $('#compartir').hide();
//             $('#borrar').show();
//         }else{
//             $('#compartirDoc').hide();
//             $('#compartir').hide();
//             $('#borrar').hide();
//         }
//     });
 
    $(document).on('click', '#selTodo', function(){
        console.log("asd");
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
                    url: "../back/borrarDocumento.php", 
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
        console.log(checks);
        if(arraydoc_id.length > 0 && validEmail === true){
            var confirmacion = confirm("¿Estás seguro de que quieres compartir los documentos seleccionados con "+email+"?");
            if(confirmacion == true){
                $.ajax({
                    type: "POST", 
                    url: "../back/compartirDocumento.php", 
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
    
    
});