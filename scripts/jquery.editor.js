$(document).ready(function() {
    $('.content').richText();

    $("#enviar").on("click", function() {
    event.preventDefault();
    let titulo = $("#titulo").val();
    let documento = $("#editortxt").val();
    let userid = $("#userid").val();
    if($.trim(titulo) == ""){
        titulo = "Sin título";
    }
    // Realizar la solicitud AJAX
    if(id_document == null){
        $.ajax({
        type: "POST", 
        url: "../back/guardardocumento.php", 
        data: {
            titulo: titulo,
            documento: documento,
            userid: userid
        },
        success: function(response) {
            // Guardar la respuesta de la bd
            id_document =response;
            alert("se ha guardado el documento con éxito.");
        }
    })
    }else{
        $.ajax({
            type: "POST", 
            url: "../back/guardardocumento.php", 
            data: {
                titulo: titulo,
                documento: documento,
                userid: userid,
                id_document: id_document
            },
            success: function(response) {
                
                alert(response);
            }
        });
    }
});
})

