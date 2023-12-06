
$("document").ready(function(){
    let menu = $("#pedirContraseña");
    let boton = $("#showPassword");
    let input = $("#contraseña");
    let guardar = $("#guardar");
    let antecedente;
    menu.hide();

    boton.on("click", function(){
        let tipoInput = input.attr('type');
        let nuevoTipo = (tipoInput === 'password') ? 'text' : 'password';
        antecedente = "ver";
        if(nuevoTipo === 'text'){
            menu.toggle();
        }else{
            menu.hide();
            let tipoInput = input.attr('type');

            // Si el tipo es 'password', cambia a 'text'; de lo contrario, cambia a 'password'
            let nuevoTipo = (tipoInput === 'password') ? 'text' : 'password';
        
            input.attr('type', nuevoTipo);
        }
        
    })

    $("#aceptar").on("click", function(){
        if(antecedente === "ver"){
            if($("#contraseñaAComprobar").val() === contraseña){
                let tipoInput = input.attr('type');
    
                // Si el tipo es 'password', cambia a 'text'; de lo contrario, cambia a 'password'
                let nuevoTipo = (tipoInput === 'password') ? 'text' : 'password';
                
                input.attr('type', nuevoTipo);
                menu.hide();
            }else{
                $("#errormsg").html("Contraseña incorrecta");
            }
        }else{
            if($("#contraseñaAComprobar").val() === contraseña){
                let nuevaContraseña = $("#contraseña").val();
                let nuevoEmail = $("#email").val();
                let formData = new FormData();
                let archivoInput = $("#archivoInput")[0];
                let archivo = archivoInput.files[0];
                formData.append("archivo", archivo);
                formData.append("nuevaContraseña", nuevaContraseña);
                formData.append("nuevoEmail", nuevoEmail);
                formData.append("user_id", user_id);
                $.ajax({
                    type: "POST", 
                    url: "../back/actualizarUsuario.php", 
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert(response);
                        window.location.reload();
                    }
                });
            }
        }


    });

    guardar.on("click", function(){
        menu.show();
        antecedente = "guardar";
    });


  
    boton.on("click", function(e) {
        e.stopPropagation();
    });

});