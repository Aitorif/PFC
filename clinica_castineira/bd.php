<?php

require_once 'databaseconnect.php';
class Crud extends Conection{
    private $table = 'trabajadores';
    public $pdo;

    public function __construct($table) {
        $this->table=(string) $table;

    }

    public function getByEmail($email){
        
        try
        {
            $pdo=parent::conexion();
            $stm = $pdo->prepare("SELECT * FROM trabajadores");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
    }
}