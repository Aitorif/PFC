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
            return false;
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
    

    public function actualizarDocumento($documento, $id){
        $sql = "UPDATE documentos SET documento = '$documento', ultima_modificacion = NOW() WHERE id = '$id'";
        $insertar = $this->db->prepare($sql);
        try{
            $insertar->execute();
            return true;
        }catch(PDOException $e){
            return $e->getMessage();
        }
}

    public function comprobarUsuario($email, $contraseña, $trabajador){
        if($trabajador == true){
            $resultado = $this->ejecutarConsulta("SELECT pass FROM trabajadores WHERE email = '$email'");
        }else{
            $resultado = $this->ejecutarConsulta("SELECT pass FROM user WHERE email = '$email'");
        }

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
}