<?php

class Database{
    private $host ="localhost";
    private $dbName ="blog";
    private $username="root";
    private $password ="";
    private $conn;
    private $result =array();
    public function __construct(){
        $this->conn =new mysqli($this->host,$this->username,$this->password,$this->dbName);
        if($this->conn->connect_error){
            die("connection failed".$this->conn->connect_error);
        }
    }
    public function insert($table,$data=array()){
        if($this->tableExists($table)){
            $columns = implode(", ",array_keys($data));
            $values = implode(", ",$data);
            $query ="INSERT INTO $table ($columns) VALUES ($values)";
            if($this->mysqli->prepare($query)){
                array_push($this->result,$this->mysqli->insert_id);
                return true;
            }else{
                array_push($this->result,$this->mysqli->error);
                return false;
            }
        }else{
            array_push($this->result."can't insert data into this table");
        }
    }
    public function getConnection(){
        return $this->conn;
    }
    public function closeConnection(){
        $this->conn->close();
    }
    private function tableExists($table){
        $query ="SHOW TABLES FROM $this->dbName LIKE '$table'";
        $stmt= $this->conn->prepare($query);
        if($tableInDb){
            if($tableInDb->num_rows==1){
                return true;
            }else{
                array_push($this->result,$table."does not exist in this database.");
                return false;
            }
        }
    }
    // generating slug //
    private function generateSlug($string) {
        $slug = strtolower($string); // Convert to lowercase
        $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug); // Replace non-alphanumeric characters with hyphens
        $slug = trim($slug, '-'); // Trim hyphens from the beginning and end
        return $slug;
    }
    public function getResult(){
        $val=$this->result;
        $this->result=array();
        return $val;
    }
    public function __destruct(){
        if($this->conn){
            if($this->conn->close()){
                $this->conn =false;
                return true;
            }
        }else{
            return false;
        }
    }
}
?>