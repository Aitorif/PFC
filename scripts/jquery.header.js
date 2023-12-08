$("document").ready(function(){
    let cuenta = $("#account");
    let menu = $("#opcionesHeader");
    let burguerMenu = $("#divBurguer");
    menu.hide();
    cuenta.on("click", function(e) {
        e.stopPropagation();


        menu.toggle();

        $(document).one("click", function() {
        menu.hide();
        });
    });
  
    menu.on("click", function(e) {
        e.stopPropagation();
    });

    $(document).on("click", function() {
        menu.hide();
    });
    console.log(burguerMenu);
    burguerMenu.on("click", function(){
        $("#sideMenu").slideToggle();
    });

});