<section id="main-container" class="flex-container">
    <div id="divLogUp" style="height: fit-content;">
        <h1>Registrar nuevo usuario</h1>
        <form action="../back/guardarUsuario.php" method="post">
            <label for="nombre">Nombre</label><input type="text" name="nombre" placeholder="Escribe tu nombre" required>
            <label for="apellidos">Apellidos</label><input type="text" name="apellidos" placeholder="Escribe tus apellidos" required>
            <label for="email">Email</label><input type="email" name="email" placeholder="Email" required>
            <label for="phone">Teléfono</label><input type="phone" name="phone" placeholder="Teléfono" required>
            <label for="dni">DNI</label><input type="text" name="dni" placeholder="DNI" required>
            <label for="contraseña">Contraseña</label><input type="password" name="contraseña" placeholder="Contraseña" required> <!--<button id="showPassword"><i id="icon">Ver</i></button>-->
            <label for="tipo">Tipo de cuenta <select name="rol" id="tipo">
                <option value="user">Usuario</option>
                <option value="admin">Administrador</option>
            </select></label>
            <input type="hidden" name="inputAdmin" value="true">
            <div class="flex-row"><input type="submit" name="enviar" id="logInButton"></div>
            <?php if(isset($result)){echo $result;} ?>
        </form> 
    </div>
</section>