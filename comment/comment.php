<?php 
session_start();
require_once "../Db.php";
// echo "<pre>";
// print_r($_POST);
// die();
// echo "</pre>";
//get all the data //
if($_SERVER["REQUEST_METHOD"]==="GET" && isset($_GET["fetchAll"])){
    $db = new Database();
    $tableName= "comment";
    echo $db->getAllData($tableName);
    header('Content-Type: application/json');
    exit;
}
// insert code //
if($_SERVER["REQUEST_METHOD"]=== "POST" && isset($_POST["insert"])){
    $db = new Database();
    $tableName ="comment";
    $name=$_POST["name"]??'';
    $email=$_POST["email"]??'';
    $comment=$_POST["comment"]??'';
    if(empty($name)|| empty($email)|| empty($comment)){
        $_SESSION['error']= "You cannot post empty comment";
        $currentPage = $_SERVER['HTTP_REFERER'];
        header("Location:$currentPage");
        exit();
    }
    $data =[
        "name"=>$name,
        "email"=>$email,
        "comment"=>$comment,
    ];
    $result=$db->insert($tableName,$data);
    if($result==="Record inserted successfully"){
        $_SESSION['success'] ="comment edit successfully";
        $currentPage = $_SERVER['HTTP_REFERER'];
        header("Location:$currentPage");
    }else{
        $_SESSION['error']= $result;
        $currentPage = $_SERVER['HTTP_REFERER'];
        header("Location:$currentPage");
    }
    exit();
}
// update code //
if($_SERVER["REQUEST_METHOD"]==="POST"&& isset($_POST["update"])){
    $db = new Database();
    $id =$_POST["id"];
    $name=$_POST["name"]??'';
    $email=$_POST["email"]??'';
    $comment=$_POST["comment"]??'';
    $tableName = "comment";
    // validate input //
    if (empty($id) || empty($name)|| empty($email)|| empty($comment)) {
        $_SESSION['error'] = "ID and Name are required.";
        $currentPage = $_SERVER['HTTP_REFERER'];
        header("Location:$currentPage");
        exit();
    } 
    $data =[
        "name"=>$name,
        "email"=>$email,
        "comment"=>$comment,
    ];
    $result=$db->update('comment',$data,["id"=>$id]);
    if ($result === "Record updated successfully") {
        $_SESSION['success'] = "comment edit successfully.";
        $currentPage = $_SERVER['HTTP_REFERER'];
        header("Location:$currentPage");
    } else {
        $_SESSION['error'] = $result;
        $currentPage = $_SERVER['HTTP_REFERER'];
        header("Location:$currentPage");    
    }
    exit();

}
?>