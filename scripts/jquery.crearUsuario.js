$(document).ready(function(){
    let boton = $("#showPassword");
    let input = $("#contraseña");

    boton.on("click", function(){
        let tipoInput = input.attr('type');

        // Si el tipo es 'password', cambia a 'text'; de lo contrario, cambia a 'password'
        let nuevoTipo = (tipoInput === 'password') ? 'text' : 'password';
    
        input.attr('type', nuevoTipo);
    })

});