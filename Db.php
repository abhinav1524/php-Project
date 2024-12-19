<?php

class Database{
    private $host ="localhost";
    private $dbName ="blog";
    private $username="root";
    private $password ="";
    private $conn;
    public function __construct(){
        $this->conn =new mysqli($this->host,$this->username,$this->password,$this->dbName);
        if($this->conn->connect_error){
            die("connection failed".$this->conn->connect_error);
        }
    }
    public function getConnection(){
        return $this->conn;
    }
    public function closeConnection(){
        $this->conn->close();
    }
}
?>