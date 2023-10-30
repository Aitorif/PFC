<?php
 
class Conection{
    
    private $host = '127.0.0.1:3307';
    private $dbname = 'clinica_castineira';
    private $username = 'root';
    private $password = 'abc123.';

    protected function conexion(){
        try {
            $pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected to {$this->dbname} at {$this->host} successfully.";
        } catch (PDOException $pe) {
            die("Could not connect to the database :" . $pe->getMessage());
        }
    }

}
