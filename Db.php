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
    public function insert($table, $data) {
        if (!$this->tableExists($table)) {
            return "Table does not exist.";
        }

        // Generate slug if a "name" field exists
        if (isset($data['name'])) {
            $data['slug'] = $this->generateSlug($data['name']);
        }

        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));
        $values = array_values($data);

        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Statement preparation failed: " . $this->conn->error);
        }

        $types = str_repeat('s', count($values)); // Assuming all values are strings for simplicity
        $stmt->bind_param($types, ...$values);

        if ($stmt->execute()) {
            $stmt->close();
            return "Record inserted successfully.";
        } else {
            $stmt->close();
            return "Error inserting record: " . $this->conn->error;
        }
    }
    public function getConnection(){
        return $this->conn;
    }
    public function closeConnection(){
        $this->conn->close();
    }
    private function tableExists($table) {
        $query = "SHOW TABLES FROM `$this->dbName` LIKE ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Statement preparation failed: " . $this->conn->error);
        }

        $stmt->bind_param("s", $table);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;

        $stmt->close();
        return $exists;
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