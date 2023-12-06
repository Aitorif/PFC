<?php

require_once 'conexion.php';
class Crud {
    
    private $db;
    public function __construct(){
        try{
            $this->db = Conexion::conexion();
        }catch(PDOException $e){
            die("Error en la conexión: ". $e->getMessage());
        }
    }

    public function ejecutarConsulta($sql){
        try{
            $resultado = $this->db->query($sql);
            return $resultado;
        }catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function guardarDocumento($documento, $usuario, $titulo){
        date_default_timezone_set('UTC');
        $sql = "CALL CrearNuevoDocumento (:titulo, :documento, :usuario, NOW())";
        $fecha = date_create()->format('Y-m-d');
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':documento', $documento, PDO::PARAM_STR);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);

        try {
            if ($stmt->execute()) {
                // Recupera el resultado del procedimiento almacenado
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result !== false) {
                    $resultado = array(true, $result['id']);
                    return $resultado ; // Devuelve el resultado del procedimiento almacenado
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    

    public function actualizarDocumento($titulo, $documento, $id){
        $sql = "UPDATE documentos SET documento = :documento, titulo=:titulo, ultima_modificacion = NOW() WHERE id = '$id'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':documento', $documento, PDO::PARAM_STR);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        try{
            $stmt->execute();
            return true;
        }catch(PDOException $e){
            return $e->getMessage();
        }
}

    public function comprobarUsuario($email, $contraseña){
        $resultado = $this->ejecutarConsulta("SELECT pass FROM user WHERE email = '$email'");
        $listado = $resultado->fetch();
        try{
            if($listado !== false){
                if($listado['pass'] == $contraseña){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }catch(PDOException $e){
                return false;
        }
        
        
    }

    public function borrarDocumentos($arraydoc_id, $user_id){
        $sql = "DELETE FROM documentos WHERE propietario = '$user_id' AND id IN (";
        foreach($arraydoc_id as $id){
            $sql .= $id.", ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= ")";
        $stmt = $this->db->prepare($sql);

        try {
            if ($stmt->execute()) {
                    return true ; 
                
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function nuevoUsuario($email, $contraseña, $nombre, $apellidos){
        $resultado = $this->ejecutarConsulta("SELECT email FROM user WHERE email = '$email'");

        $listado = $resultado->fetch();

        try{
            if($listado == false){
                $sql = "INSERT INTO user(nombre, apellidos, email, pass) VALUES ('$nombre', '$apellidos', '$email', '$contraseña')";
                $insertar = $this->db->prepare($sql);
                if($insertar->execute()){
                    return "Nuevo usuario creado con éxito";
                }else{
                    return "No se ha podido crear el usuario";
                }
            }else{
                return "Ha habido un error al crear el usuario";
            }
        }catch(PDOException $e){
                return $e->getMessage();;
        }
    }

    public function compartirDocumento($arraydoc_id, $id_user, $id_trab){
        $sql = "INSERT IGNORE INTO documento_compartido (id_documento, id_trabajador, id_user) VALUES ";
        foreach($arraydoc_id as $id_doc){
            $sql .= "('$id_doc', '$id_trab', '$id_user'),";
        }
        $sql = substr($sql, 0, -1);
        $stmt = $this->db->prepare($sql);
        try{
            $insertar = $this->db->prepare($sql);
                    if($insertar->execute()){
                        return true;
                    }else{
                        return false;
                    }
        }catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function registrarCita($id_paciente, $id_trabajador, $dia, $hora){
        $sql = "INSERT INTO citas(id_trabajador, id_paciente, dia, hora) VALUES(:id_trabajador, :id_paciente, :dia, '$hora')";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_trabajador', $id_trabajador, PDO::PARAM_STR);
        $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_STR);
        $stmt->bindParam(':dia', $dia, PDO::PARAM_STR);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function crearUsuario($nombre, $apellidos, $email, $contraseña, $direccion, $dni, $telefono){
        $sql = "INSERT INTO user(nombre, apellidos, email, pass, direccion, dni, telefono) VALUES(:nombre, :apellidos, :email, :pass, :direccion, :dni, :telefono)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $contraseña, PDO::PARAM_STR);
        $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function crearUsuarioAdmin($nombre, $apellidos, $email, $contraseña, $direccion, $telefono, $dni, $rol){
        $sql = "INSERT INTO user(nombre, apellidos, email, pass, direccion, dni, rol, trabajador, telefono) VALUES(:nombre, :apellidos, :email, :pass, :direccion, :dni, :rol, :trabajador, :telefono )";
        $stmt = $this->db->prepare($sql);
        $trabajador = "true";
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $contraseña, PDO::PARAM_STR);
        $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
        $stmt->bindParam(':trabajador', $trabajador, PDO::PARAM_STR);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function borrarCita($id){
        $sql = "DELETE FROM citas WHERE id = '$id' ";
        $stmt = $this->db->prepare($sql);

        try {
            if ($stmt->execute()) {
                    return true ; 
                
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function guardarFactura($cliente, $fecha, $descripcion, $cantidad, $precioUnitario, $precioTotal){
        $sql = "INSERT INTO facturas(fecha, descripcion, id_user, cantidad, precioUnitario, precioTotal )VALUES(:fecha, :descripcion, :id_user, :cantidad, :precioUnitario, :precioTotal)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $cliente, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_STR);
        $stmt->bindParam(':precioUnitario', $precioUnitario, PDO::PARAM_STR);
        $stmt->bindParam(':precioTotal', $precioTotal, PDO::PARAM_STR);
        try {
            $stmt->execute();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }

    public function actualizarUsuario($id, $pass, $imagen = "userphoto.png"){
        $sql = "UPDATE user SET photo = :imagen, pass = :pass WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":imagen", $imagen, PDO::PARAM_STR);
        $stmt->bindParam(":pass", $pass, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function actualizarRol($id, $rol){
        $sql = "UPDATE user SET rol = :rol WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":rol", $rol, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function borrarUsuario($id){
        $sql = "DELETE FROM user WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}