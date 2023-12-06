$(document).ready(function() {
    
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
            nuevaFila.append("<td>"+data[i]['id']+"</td><td>"+data[i]['fecha']+"</td><td><a style='color: black;' target='_blank' href='http://localhost/clinica_castineira/vistas/previstaFactura.php?id_factura="+data[i]['id']+"'>Imprimir</a></td>");
            tabla.append(nuevaFila);
        }
    }

    function nuevaPagina(pagina){
        let indiceInicio = (pagina - 1) * 10;
        
        $.ajax({
                    type: "POST", 
                    url: "../back/getFacturas.php", 
                    data: {
                        indiceInicio: indiceInicio
                    },
                    success: function(response) {
                        console.log(response)
                        try{
                            let data = JSON.parse(response);
                            
                            actualizaTabla(data);
                        }catch(error){
                            $('#documentos').html("<h2>Todavía no tienes ningún documento</h2>")
                        }
                        
                    }
        })
    }
   
});