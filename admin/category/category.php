<?php
session_start();
require_once '../../Db.php';
// checking the url has id or not //
$id = $_GET['id'] ?? '';
if (!$id) {
    $_SESSION['error'] = "ID is missing.";
    header("Location: ./index.php");
    exit();
}
   if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $db =new Database();
    $name =$_POST['name']??'';
    if(empty($name)){
        $_SESSION['error']= "Name is required";
        header("Location:./index.php");
        exit();
    }
    $data=['name'=>$name];
    $result=$db->insert('categories', $data);
    if($result==="Record inserted successfully"){
        $_SESSION['success'] ="Category added successfully";
        header('Location:./index.php');
    }else{
        $_SESSION['error']= $result;
        header("Location:./index.php");
    }
    exit();
   }
   // update category //
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
}

$category = $db->getOne('categories', ['id' => $id]);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    
    // Validate input
    if (empty($id) || empty($name)) {
        $_SESSION['error'] = "ID and Name are required.";
        header("Location: ./index.php");
        exit();
    }
    
    $data = ['name' => $name]; // Data to update
    $result = $db->update('categories', $data, ['id' => $id]);
    
    if ($result === "Record updated successfully") {
        $_SESSION['success'] = "Category updated successfully.";
        header('Location: ./index.php');
    } else {
        $_SESSION['error'] = $result;
        header("Location: ./index.php");
    }
    exit();
}

?>