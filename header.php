
    <div class="divContacto">
        <div><img class="pngs" src="./media/telefono.png"/><span>981254789</span></div>
        <div><img class="pngs" src="./media/email.png"/><span>ejemplo@clinicacastineira.com</span></div>
        <div><a href="#"><img class="pngs" src="./media/insta.png"/></a><a href="#"><img class="pngs" src="media/facebook.png"/></a></div>  
    </div>
    <header class="Header">
        <div class="divHeader">
            <a href="#" class="logo"><div ><h2 class="h2Logo">Clinica Castiñeira</h2></div></a>
            <div id="contNav">
                <span>Bienvenid@ <?php if(isset($_SESSION["nombre"])){ echo $_SESSION["nombre"]. " ".$_SESSION["apellidos"];} if(isset($_COOKIE["login"]) && $_COOKIE["login"] == "loged"){echo "<a href='cerrarSesion.php'><button>Cerrar sesión</button></a>";}?> </span>
                <nav>
                    <ul class="menu">
                        <a href="#"><li class="menuItem">Inicio</li></a>
                        <a href="#"><li class="menuItem">Sobre nosotras</li></a>
                        <a href="#"><li class="menuItem">Nuestro equipo</li></a>
                        <a href="login.php"><li class="menuItem">Login</li></a>
                        <a href="#"><li class="menuItem">Contacto</li></a>
                    </ul>
                </nav>
            </div>
        </div>     
    </header>
