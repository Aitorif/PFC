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

    //Operaciones USUARIO

    public function crearUsuario($nombre, $apellidos, $email, $contraseña, $direccion, $telefono, $dni, $rol = "user", $trabajador = "false"){
        $sql = "INSERT INTO user(nombre, apellidos, email, pass, direccion, dni, rol, trabajador, telefono) VALUES(:nombre, :apellidos, :email, :pass, :direccion, :dni, :rol, :trabajador, :telefono )";
        $stmt = $this->db->prepare($sql);
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

    public function actualizarUsuario($id, $pass, $imagen = "noImage"){
        if($imagen === "noImage"){
            $sql = "UPDATE user SET pass = :pass WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":pass", $pass, PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        }else{
            $sql = "UPDATE user SET photo = :imagen, pass = :pass WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":imagen", $imagen, PDO::PARAM_STR);
            $stmt->bindParam(":pass", $pass, PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        }

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

    public function getUserById($id){
        $sql = "SELECT nombre, apellidos, dni, direccion FROM user WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        try {
            $resultado = $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            return $usuario;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    } 

    public function getTrabajadores(){
        $result = $this->ejecutarConsulta("SELECT id, nombre, apellidos FROM user WHERE trabajador = 'true'");
        return $result;
    }

    public function getPacientes(){
        $result = $this->ejecutarConsulta("SELECT id, nombre, apellidos FROM user WHERE trabajador = 'false'");
        return $result;
    }

    public function getTrabajadoresAdminOnly($rol){
        if($rol === "admin"){
            $result = $this->ejecutarConsulta("SELECT id, nombre, apellidos, dni, telefono, email, rol
            FROM user WHERE trabajador = 'true'
            ORDER BY nombre, apellidos DESC");
            return $result;
        }
    }

    public function getPacientesAdminOnly($rol){
        if($rol === "admin"){
            $result = $this->ejecutarConsulta("SELECT id, nombre, apellidos, email FROM user WHERE trabajador = 'false'");
            return $result;
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

    //DOCUMENTOS

    public function getDocumentoPag($user_id, $indiceInicio){

            $result1 = $this->ejecutarConsulta("SELECT d.id, d.titulo, d.ultima_modificacion, t.nombre FROM documentos as d INNER JOIN user as t ON d.propietario = t.id WHERE d.propietario = $user_id LIMIT $indiceInicio, 10");

            $result2 = $this->ejecutarConsulta("SELECT d.id, d.titulo, t.nombre FROM documentos as d INNER JOIN documento_compartido as dc ON d.id = dc.id_documento INNER JOIN user AS t ON dc.id_trabajador = t.id WHERE dc.id_user = $user_id LIMIT $indiceInicio, 10");
            $array1 = $result1->fetchAll();
            $array2 = $result2->fetchAll();
            $combinedResult = array_merge($array1, $array2);
        return $combinedResult;
    }

    public function getDocById($doc_id, $user_id){
        $sql = "SELECT d.documento, d.titulo
        FROM documentos d
        LEFT JOIN documento_compartido dc ON d.id = dc.id_documento AND dc.id_user = 1
        WHERE d.id = :id AND (d.propietario = :user_id OR dc.id_user = :user_id);";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $doc_id, PDO::PARAM_INT);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

        try {
            $resultado = $stmt->execute();
            $documento = $stmt->fetch(PDO::FETCH_ASSOC);
            return $documento;
        } catch (PDOException $e) {
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

    
    public function getFacturaById($doc_id){
        $sql = "SELECT u.nombre, u.apellidos, u.dni, u.direccion, f.id_user, f.fecha, f.descripcion, f.cantidad, f.precioUnitario, f.precioTotal FROM facturas f INNER JOIN user u ON f.id_user = u.id WHERE f.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $doc_id, PDO::PARAM_INT);

        try {
            $resultado = $stmt->execute();
            $documento = $stmt->fetch(PDO::FETCH_ASSOC);
            return $documento;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //CITAS
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

    public function getCitas($rol, $user_id, $trabajador){
        if($trabajador == true && $rol != "admin"){
            $result = $this->ejecutarConsulta("SELECT c.dia, c.hora, u.nombre as nombre_paciente, u.nombre as nombre_trabajador, c.id
            FROM citas as c
            INNER JOIN user as t ON c.id_trabajador = t.id
            INNER JOIN user as u ON c.id_paciente = u.id
            WHERE id_trabajador = $user_id
            ORDER BY c.dia, SUBSTRING(c.hora, 1, 2), SUBSTRING(c.hora, 4, 5) DESC");
            
        }else if($trabajador == true && $rol == "admin"){
            $result = $this->ejecutarConsulta("SELECT c.dia, c.hora, u.nombre as nombre_paciente, t.nombre as nombre_trabajador, c.id
            FROM citas as c
            INNER JOIN user as t ON c.id_trabajador = t.id
            INNER JOIN user as u ON c.id_paciente = u.id
            ORDER BY c.dia, SUBSTRING(c.hora, 1, 2), SUBSTRING(c.hora, 4, 5) DESC");
        
        }else{
            $result = $this->ejecutarConsulta("SELECT c.dia, c.hora, u.nombre as nombre_paciente, t.nombre as nombre_trabajador, c.id
            FROM citas as c
            INNER JOIN user as t ON c.id_trabajador = t.id
            INNER JOIN user as u ON c.id_paciente = u.id
            WHERE id_paciente = $user_id
            ORDER BY c.dia, c.hora");
        }
        return $result;
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






}
