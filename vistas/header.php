<header class="Header">
    <script type="text/javascript" src="../scripts/jquery.header.js"></script>
    <div class="flex-container" id="header1">
        <div class="divContacto">
            <div><img class="pngs" src="../media/telefono.png"/><span>981254789</span></div>
            <div><img class="pngs" src="../media/email.png"/><span>ejemplo@clinicacastineira.com</span></div>
            <div><a href="#"><img class="pngs" src="../media/insta.png"/></a><a href="#"><img class="pngs" src="../media/facebook.png"/></a></div>  
        </div>
    </div>
    <div class="divHeader">
        <a href="../index.php" id="logo"><div ><img src="../assets/CLINICA_CASTIÑEIRA.png" alt=""></div></a>
        <div id="contNav">
            <span><?php if(isset($_SESSION["nombre"])){ echo "<a id='account' class='login' href='#'><img id='userImg' src='../assets/uploads/user-img/".$_SESSION['foto']."'/>";}else{echo "<a class='login' href='login.php'><i id='userIcon'></i></a>";} 
            if(isset($_COOKIE["login"]) && $_COOKIE["login"] == "loged"){
                echo "<div id='opcionesHeader'><a href='datosUsuario.php'>".$_SESSION['nombre']."</a><hr><a href='../back/cerrarSesion.php'><button>Cerrar sesión</button></a></div>";
            }?> </span>
            <nav>
                <ul class="menu">
                    <a href="index.php"><li class="menuItem">Inicio</li></a>
                    <a href="#"><li class="menuItem">Sobre nosotras</li></a>
                    <a href="#"><li class="menuItem">Nuestro equipo</li></a>
                    <a href="#"><li class="menuItem">Contacto</li></a>
                </ul>
            </nav>
            <nav id="menuMovil">
                <img src="../assets/uploads/burguer.svg" alt="">
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
                    <a href="./citas.php"><li class="submenuItem">Citas</li></a>
                    <?php if($_SESSION["rol"] == "admin"){?><a href="./gestorUsuarios.php"><li class="submenuItem">Usuarios</li></a> <?php } ?>
                </ul>
            </div>
        </div>
    <?php   
    }
    ?>
</header>
