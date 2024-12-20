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

    // getting the data //
    public function getAllData($table) {
        $table = $this->conn->real_escape_string($table); // Prevent SQL injection
        $query = "SELECT * FROM `$table`";

        $result = $this->conn->query($query);

        if ($result) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return json_encode($data); // Convert the result to JSON format
        } else {
            return json_encode(["error" => "Query failed: " . $this->conn->error]);
        }
    }
    // inserting value in database
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
    $table = $this->conn->real_escape_string($table); // Sanitize table name to prevent SQL injection
    $query = "SHOW TABLES FROM `$this->dbName` LIKE '$table'";
    $result = $this->conn->query($query);

    if (!$result) {
        die("Query execution failed: " . $this->conn->error);
    }

    $exists = $result->num_rows > 0;
    $result->free(); // Free the result set memory

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
// hitting the api request to get data and parse it into a json format //
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['table'])) {
    // Create a new instance of the Database class
    $db = new Database("localhost", "root", "", "blog");

    header('Content-Type: application/json'); // Set JSON header

    $tableName = $_GET['table'];
    echo $db->getAllData($tableName); // Fetch and return table data in JSON format

    $db->closeConnection(); // Close the connection
    exit;
}
?>