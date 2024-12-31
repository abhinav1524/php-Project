<?php 
session_start();
require_once "./Db.php";
//get all the data //
if($_SERVER["REQUEST_METHOD"]==="GET" && isset($_GET["fetchAll"])){
    $db = new Database();
    $tableName= "comments";
    echo $db->getAllData($tableName);
    header('Content-Type: application/json');
    exit;
}
// insert code //
if($_SERVER["REQUEST_METHOD"]=== "POST" && isset($_POST["insert"])){
    $db = new Database();
    $tableName ="comments";
    $name=$_POST["name"]??'';
    if(empty($name)){
        $_SESSION['error']= "You cannot post empty comment";
        header("Location:./index.php");
        exit();
    }
    $data =["name"=>$name];
    $result=$db->insert($tableName,$data);
    if($result==="Record inserted successfully"){
        $_SESSION['success'] ="Tag added successfully";
        header('Location:./index.php');
    }else{
        $_SESSION['error']= $result;
        header("Location:./index.php");
    }
    exit();
}

?>