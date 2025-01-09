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
    // echo "<pre>";
    // print_r($_POST);
    // die();
    // echo "</pre>";
    $db = new Database();
    $tableName ="comment";
    $currentUserId = $_SESSION['user']['id'];
    $post_id =$_POST["post_id"];
    $parentId =null;
    $name=$_POST["name"]??'';
    $email=$_POST["email"]??'';
    $comment=$_POST["comment"]??'';
    if(empty($post_id)||empty($name)|| empty($email)|| empty($comment) || empty($currentUserId)){
        $_SESSION['error']= "You cannot post empty comment";
        $currentPage = $_SERVER['HTTP_REFERER'];
        header("Location:$currentPage");
        exit();
    }
    $data =[
        "name"=>$name,
        "email"=>$email,
        "comment"=>$comment,
        "post_id"=>$post_id,
        "parent_id"=>$parentId,
        "user_id"=>$currentUserId
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
// Handle saving the reply
if ($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($_POST["submitReply"])) {
    // echo "<pre>";
    // print_r($_POST);
    // die();
    // echo "</pre>";
    $db = new Database();
    $tableName ="comment";
    $currentUserId = $_SESSION['user']['id'];
    $postId = $_POST['post_id'];
    $parentId =$_POST['parent_id'??null]; // This can be 0 for a top-level comment
    $commentText = $_POST['reply'];
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    // Validate input
    if (empty($post_id) || empty($parent_id) || empty($userName) || empty($userEmail) || empty($reply) || empty($currentUserId)) {
        // Prepare the insert statement
        $data =[
        "name"=>$userName,
        "email"=>$userEmail,
        "comment"=>$commentText,
        "post_id"=>$postId,
        "parent_id"=>$parentId,
        "user_id"=>$currentUserId
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
}

// update reply comment //
if($_SERVER["REQUEST_METHOD"]==="POST"&& isset($_POST["updateReplyComment"])){
    // echo "<pre>";
    // print_r($_POST);
    // die();
    // echo "</pre>";
    $db = new Database();
    $currentUserId = $_SESSION['user']['id'];
    $id=$_POST["comment_id"];
    $postId = $_POST['post_id'];
    $commentText = $_POST['updated_comment'];
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    // validate input //
    if (empty($commentText)) {
        $_SESSION['error'] = "All fields are required.";
        $currentPage = $_SERVER['HTTP_REFERER'];
        header("Location:$currentPage");
        exit();
    } 
    $data =[
        "name"=>$userName,
        "email"=>$userEmail,
        "comment"=>$commentText,
        "post_id"=>$postId,
        "user_id"=>$currentUserId
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
// delete code //
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Read and decode the raw JSON input
    $data = json_decode(file_get_contents('php://input'), true);
    // Validate the 'id'
    if (!isset($data['comment_id']) || empty($data['comment_id']) || !isset($data['parent_id']) || empty($data['parent_id'])) {
        echo json_encode(['success' => false, 'error' => 'Comment ID or Parent ID is missing or invalid.']);
        exit();
    }
    // $currentUserId = $_SESSION['user']['id'];
    $commentId = intval($data['comment_id']); // Ensuring ID is treated as an integer
    $parentId = intval($data['parent_id']);
    $db = new Database();
    $comment = $db->getData('comment', null, '*', "WHERE id = $commentId")[0];
     if ($comment) {
        if ($comment['parent_id'] === null) {
            // Case 1: Delete parent comment and its children
            $db->delete('comment', ['id' => $commentId]); // Delete the parent comment
            $db->delete('comment', ['parent_id' => $commentId]); // Delete child comments
        } else {
            // Case 2: Delete only the child comment
            $db->delete('comment', ['id' => $commentId]);
        }
        echo json_encode(['success' => true,'message'=>"Comment deleted successfully!"]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Comment not found!']);
    }
    exit();
}

?>