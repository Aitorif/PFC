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
            return "No se ha podido acceder a la consulta". $e->getMessage();
        }
    }

    public function guardarDocumento($documento, $usuario, $titulo){
        $sql = "CALL CrearNuevoDocumento (:titulo, :documento, :usuario)";
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
        $sql = "UPDATE documentos SET documento = '$documento' WHERE id = '$id'";
        $insertar = $this->db->prepare($sql);
        try{
            $insertar->execute();
            return true;
        }catch(PDOException $e){
            return $e->getMessage();
        }
}

    public function comprobarUsuario($email, $contraseña){
        $resultado = $this->ejecutarConsulta("SELECT pass FROM trabajadores WHERE email = '$email'");
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

}