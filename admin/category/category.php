<?php
session_start();
require_once '../../Db.php';

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
?>