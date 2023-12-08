<section id="main-container " class="flex-container admin">
    <div id="divLogUp" style="height: fit-content;">
        <h1>Registrar nuevo usuario</h1>
        <form action="../back/guardarUsuario.php" method="post">
            <label for="nombre">Nombre<input type="text" name="nombre" placeholder="Escribe tu nombre" required></label>
            <label for="apellidos">Apellidos<input type="text" name="apellidos" placeholder="Escribe tus apellidos" required></label>
            <label for="email">Email<input type="email" name="email" placeholder="Email" required></label>
            <label for="phone">Teléfono<input type="phone" name="phone" placeholder="Teléfono" required></label>
            <label for="dni">DNI<input type="text" name="DNI" placeholder="DNI" required></label>
            <label for="direccion">Direccion<input type="text" name="direccion" placeholder="Dirección" required></label>
            <label for="contraseña">Contraseña<div id="divPass"><input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
            <button id="showPassword">Ver</button></div></label> 
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
<script>
        $("#showPassword").on("click", function(){
            let tipoInput = $("#contraseña").attr('type');
            let nuevoTipo = (tipoInput === 'password') ? 'text' : 'password';
            if(nuevoTipo ==="password"){
                $("#showPassword").css("text-decoration", "none");
            }else{
                $("#showPassword").css("text-decoration", "line-through");
            }
            $("#contraseña").attr('type', nuevoTipo);

            
        })
</script>