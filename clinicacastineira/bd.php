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
            $sql = "INSERT INTO documentos (documento, propietario, titulo) VALUES ('$documento', '$usuario', '$titulo')";
            $insertar = $this->db->prepare($sql);
            try{
                $insertar->execute();
                return true;
            }catch(PDOException $e){
                return $e->getMessage();
            }
    }

    public function comprobarUsuario($email, $contraseña){
        $resultado = $this->ejecutarConsulta("SELECT contraseña FROM trabajadores WHERE email = '$email'");
        $listado = $resultado->fetch();
        try{
            if($listado !== false){
                if($listado['contraseña'] == $contraseña){
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