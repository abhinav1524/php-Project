<?php
session_start();
require_once '../../Db.php';
//getting all data //
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['fetchAll'])) {
    // Create a new instance of the Database class
    $db = new Database();
    $tableName = 'tags';
    echo $db->getAllData($tableName); // Fetch and return table data in JSON format
    header('Content-Type: application/json');
    exit;
}
// insert code //
   if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['insert'])){
    $db =new Database();
    $name =$_POST['name']??'';
    if(empty($name)){
        $_SESSION['error']= "Name is required";
        header("Location:./index.php");
        exit();
    }
    $data=['name'=>$name];
    $result=$db->insert('tags', $data);
    if($result==="Record inserted successfully"){
        $_SESSION['success'] ="Tag added successfully";
        header('Location:./index.php');
    }else{
        $_SESSION['error']= $result;
        header("Location:./index.php");
    }
    exit();
   }
   // update code //
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $db = new Database();
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';  
    // Validate input
    if (empty($id) || empty($name)) {
        $_SESSION['error'] = "ID and Name are required.";
        header("Location: ./index.php");
        exit();
    } 
    $data = ['name' => $name]; // Data to update
    $result = $db->update('tags', $data, ['id' => $id]);    
    if ($result === "Record updated successfully") {
        $_SESSION['success'] = "Tag updated successfully.";
        header('Location: ./index.php');
    } else {
        $_SESSION['error'] = $result;
        header("Location: ./index.php");
    }
    exit();
}
 //  delete code //
 if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Read and decode the raw JSON input
    $data = json_decode(file_get_contents('php://input'), true);
    // Validate the 'id'
    if (!isset($data['id']) || empty($data['id'])) {
        echo json_encode(['success' => false, 'error' => 'ID is missing or invalid.']);
        exit();
    }
    $id = intval($data['id']); // Ensuring ID is treated as an integer
    require_once '../../Db.php';
    $db = new Database();
    // Call the delete function
    $result = $db->delete('tags', ['id' => $id]);
    if ($result === "Record deleted successfully") {
        echo json_encode(['success' => true, 'message' => 'Category deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'error' => $result]);
    }
    exit();
}

?>