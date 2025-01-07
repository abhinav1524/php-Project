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
    $post_id =$_POST["post_id"??null];
    $name=$_POST["name"]??'';
    $email=$_POST["email"]??'';
    $comment=$_POST["comment"]??'';
    if(empty($post_id)||empty($name)|| empty($email)|| empty($comment)){
        $_SESSION['error']= "You cannot post empty comment";
        $currentPage = $_SERVER['HTTP_REFERER'];
        header("Location:$currentPage");
        exit();
    }
    $data =[
        "name"=>$name,
        "email"=>$email,
        "comment"=>$comment,
        "post_id"=>$post_id
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
// Handle saving the reply
if ($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($_POST["submitReply"])) {
    // echo "<pre>";
    // print_r($_POST);
    // die();
    // echo "</pre>";
    $db = new Database();
    $conn = $db->getConnection();
     // Fetch user details from session
    // Validate input
    if (empty($post_id) || empty($parent_id) || empty($userName) || empty($userEmail) || empty($reply)) {
        $postId = $_POST['post_id'];
        $parentId =$_POST['parent_id']; // This can be 0 for a top-level comment
        $commentText = $_POST['reply'];
        $userName = $_POST['userName'];
        $userEmail = $_POST['userEmail'];
        // Prepare the insert statement
        $query = "INSERT INTO comment (name, email, comment, parent_id, post_id ,created_at) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Bind parameters to the query
             $stmt->bind_param('sssii', $userName, $userEmail, $commentText, $parentId, $postId);
            
            if ($stmt->execute()) {
                $_SESSION['success'] = "Reply added successfully.";
                $currentPage = $_SERVER['HTTP_REFERER'];
                header("Location:$currentPage");
            } else {
                echo "Error: ".$stmt->error;
            }
        } 
    } else {
        echo "Invalid Request";
    }
}

?>