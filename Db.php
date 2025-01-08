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

    // getting the data in json format  //
    public function getAllData($table,$join=null,$select="*"){
        $table = $this->conn->real_escape_string($table); // Prevent SQL injection
        // If a join is provided, append it to the query
        $joinQuery = $join ? " $join" : '';
        $query = "SELECT $select FROM `$table`".$joinQuery;
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
    // get data in array format //
    public function getData($table,$join=null,$select="*",$where=null) {
    $table = $this->conn->real_escape_string($table); // Prevent SQL injection
    $joinQuery = $join ? " $join" : '';
    $whereQuery = $where ? " $where" : ''; 
    $query = "SELECT $select FROM `$table`".$joinQuery.$whereQuery;
    $result = $this->conn->query($query);

    if ($result) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data; // Return an array of the result
    } else {
        return ["error" => "Query failed: " . $this->conn->error];
    }
}

    // inserting value in database
    public function insert($table, $data) {
        // die("come in the insert code in db.php");
        if (!$this->tableExists($table)) {
            return "Table does not exist.";
        }
        // Generate slug if a "name" field exists
        if ($table !== 'comment') {
        if (isset($data['name'])) {
            $data['slug'] = $this->generateSlug($data['name']);
        } elseif (isset($data['title'])) {
            $data['slug'] = $this->generateSlug($data['title']);
        }
    }
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));
        $values = array_values($data);
        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        //  echo "<pre>";
        //  print_r($query);
        //  die();
        //  echo "</pre>";
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
    // getting the old data to update //
    public function getOne($table, $conditions) {
        $table = $this->conn->real_escape_string($table); // Prevent SQL injection
        $whereClause = ''; // Initialize where clause
        $firstCondition = true;
    
        foreach ($conditions as $key => $value) {
            $value = $this->conn->real_escape_string($value); // Prevent SQL injection
            if (!$firstCondition) {
                $whereClause .= ' AND ';
            }
            $whereClause .= "`$key` = '$value'";
            $firstCondition = false;
        }
    
        $query = "SELECT * FROM `$table` WHERE $whereClause LIMIT 1";
        $result = $this->conn->query($query);
    
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc(); // Return the fetched row as an associative array
        } else {
            return null; // Return null if no record is found
        }
    }
    
    
    // updating values in database //
    public function update($table, $data, $where) {
    $table = $this->conn->real_escape_string($table);
    $whereKey = array_keys($where)[0];
    $whereValue = $this->conn->real_escape_string($where[$whereKey]);

    // Generate slug from the name and add it to the $data array
        $excludeSlugTables = ['comment', 'another_table_without_slug']; // Add table names to exclude
    if (!in_array($table, $excludeSlugTables)) {
        if (!isset($data['slug'])) { // Only generate slug if it is not already set
            if (isset($data['name'])) {
                $data['slug'] = $this->generateSlug($data['name']);
            } elseif (isset($data['title'])) {
                $data['slug'] = $this->generateSlug($data['title']);
            }
        }
    }
    $updates = [];
    foreach ($data as $column => $value) {
        $column = $this->conn->real_escape_string($column);
        $value = $this->conn->real_escape_string($value);
        $updates[] = "`$column` = '$value'";
    }
    $query = "UPDATE `$table` SET " . implode(', ', $updates) . " WHERE `$whereKey` = '$whereValue'";
    if ($this->conn->query($query)) {
        return json_encode(["success" => true, "message" => "Record updated successfully."]);
    } else {
        return json_encode(["success" => false, "error" => "Error updating record: " . $this->conn->error]);
    }
}
// delete code //
public function delete($table, $where) {
    $table = $this->conn->real_escape_string($table);
    $whereKey = array_keys($where)[0];
    $whereValue = $this->conn->real_escape_string($where[$whereKey]);
    $query = "DELETE FROM `$table` WHERE `$whereKey` = '$whereValue'";
    if ($this->conn->query($query)) {
        return "Record deleted successfully";
    } else {
        return "Error deleting record: " . $this->conn->error;
    }
}
public function deleteAllChildren($table, $parentId) {
$table = $this->conn->real_escape_string($table);
    $parentId = intval($parentId);
    $query = "DELETE FROM `$table` WHERE `parent_id` = '$parentId'";
    if ($this->conn->query($query)) {
        return "Record deleted successfully";
    } else {
        return "Error deleting records: " . $this->conn->error;
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
?>