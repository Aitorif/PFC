$('document').ready(function(){



    if ($('#texto').length & $('#titulo').length) {
        $('#texto').html(documento);
        $('#titulo').html(titulo); 
    }

    $("#imprimir")[0].style.display = "none";
    $(window).on("load", function() {
        setTimeout(function() {
            window.print();
        }, 500);
    });
    $(window).on("afterprint", function(){
        $("#imprimir")[0].style.display = "";
    });
    $("#imprimir").click(function (){
        this.style.display = "none";
        window.print();
        this.style.display = "";
    })
})