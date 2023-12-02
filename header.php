<header class="Header">
    <div class="flex-container">
        <div class="divContacto">
            <div><img class="pngs" src="./media/telefono.png"/><span>981254789</span></div>
            <div><img class="pngs" src="./media/email.png"/><span>ejemplo@clinicacastineira.com</span></div>
            <div><a href="#"><img class="pngs" src="./media/insta.png"/></a><a href="#"><img class="pngs" src="media/facebook.png"/></a></div>  
        </div>
    </div>
    <div class="divHeader">
        <a href="index.php" id="logo"><div ><img src="./assets/CLINICA_CASTIÑEIRA.png" alt=""></div></a>
        <div id="contNav">
            <span><?php if(isset($_SESSION["nombre"])){ echo "<a id='account' class='login' href='#'><i id='userIcon'></i>Mi cuenta</a>";}else{echo "<a class='login' href='login.php'><i id='userIcon'></i></a>";} 
            if(isset($_COOKIE["login"]) && $_COOKIE["login"] == "loged"){
                echo "<div id='opcionesHeader'><a href='datosUsuario.php'>Espacio personal</a><hr><a href='cerrarSesion.php'><button>Cerrar sesión</button></a></div>";
            }?> </span>
            <nav>
                <ul class="menu">
                    <a href="index.php"><li class="menuItem">Inicio</li></a>
                    <a href="#"><li class="menuItem">Sobre nosotras</li></a>
                    <a href="#"><li class="menuItem">Nuestro equipo</li></a>
                    <a href="#"><li class="menuItem">Contacto</li></a>
                </ul>
            </nav>
        </div>
    </div>     
    <?php

    if(isset($_COOKIE["login"])){
        ?>
        <div class="sub-container">
            <div class="subMenu">
                <ul class="submenu">
                    <a href="./documentos.php"><li class="submenuItem">Mis Documentos</li></a>
                    <a href="./registrarCita.php"><li class="submenuItem">Citas</li></a>
                    <?php if($_SESSION["rol"] == "admin"){?><a href="./gestorUsuarios.php"><li class="submenuItem">Usuarios</li></a> <?php } ?>
                </ul>
            </div>
        </div>
    <?php   
    }
    ?>
    <script>
        $("document").ready(function(){
            let cuenta = $("#account");
            let menu = $("#opcionesHeader");

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

        });
    </script>
</header>
