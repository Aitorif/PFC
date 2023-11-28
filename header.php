<header class="Header">
    <div class="flex-container">
        <div class="divContacto">
            <div><img class="pngs" src="./media/telefono.png"/><span>981254789</span></div>
            <div><img class="pngs" src="./media/email.png"/><span>ejemplo@clinicacastineira.com</span></div>
            <div><a href="#"><img class="pngs" src="./media/insta.png"/></a><a href="#"><img class="pngs" src="media/facebook.png"/></a></div>  
        </div>
    </div>
    <div class="divHeader">
        <a href="index.php" class="logo"><div ><h2 class="h2Logo">Clinica Castiñeira</h2></div></a>
        <div id="contNav">
            <span><?php if(isset($_SESSION["nombre"])){ echo "<a class='login' href='#'>Mi cuenta</a>";}else{echo "<a class='login' href='login.php'>Iniciar sesión</a>";} if(isset($_COOKIE["login"]) && $_COOKIE["login"] == "loged"){echo "<a href='cerrarSesion.php'><button>Cerrar sesión</button></a>";}?> </span>
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
                    <?php if($_SESSION["trabajador"] == true){?><a href="./editor.php"><li class="submenuItem">Editor</li></a> <?php } ?>
                    <a href="./registrarCita.php"><li class="submenuItem">Citas</li></a>
                </ul>
            </div>
        </div>
    <?php   
    }
    ?>
</header>
