<?php


class Conexion{
    const SERVIDOR = "localhost:3307";
    const DBNAME = "clinica";
    const USUARIO = "root";
    const CONTRASEÑA = "abc123.";
    
    public static function conexion(){
        $stm = "mysql:host=localhost:3307;dbname=".self::DBNAME;
        $conexion = new PDO($stm, self::USUARIO, self::CONTRASEÑA);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    }
}