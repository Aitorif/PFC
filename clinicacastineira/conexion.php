<?php


class Conexion{
    const SERVIDOR = "localhost:3307";
    const DBNAME = "clinica_castineira";
    const USUARIO = "root";
    const CONTRASEÑA = "abc123.";
    
    public static function conexion(){
        $stm = "mysql:host=localhost;dbname=".self::DBNAME;
        $conexion = new PDO($stm, self::USUARIO, self::CONTRASEÑA);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    }
}