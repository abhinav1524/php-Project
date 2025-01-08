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
// Handle saving the reply
if ($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($_POST["submitReply"])) {
    // echo "<pre>";
    // print_r($_POST);
    // die();
    // echo "</pre>";
    $db = new Database();
    $tableName ="comment";
    $postId = $_POST['post_id'];
    $parentId =$_POST['parent_id']; // This can be 0 for a top-level comment
    $commentText = $_POST['reply'];
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    // Validate input
    if (empty($post_id) || empty($parent_id) || empty($userName) || empty($userEmail) || empty($reply)) {
        // Prepare the insert statement
        $data =[
        "name"=>$userName,
        "email"=>$userEmail,
        "comment"=>$commentText,
        "post_id"=>$postId,
        "parent_id"=>$parentId
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
    $id=$_POST["comment_id"];
    $postId = $_POST['post_id'];
    $parentId =$_POST['parent_id'??0]; // This can be 0 for a top-level comment
    $commentText = $_POST['updated_comment'];
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    // validate input //
    if (empty($commentText)) {
        $_SESSION['error'] = "All fields are required.";
        $currentPage = $_SERVER['HTTP_REFERER'];
        echo "<pre>";
        print_r("validate condition is not  passed");
        die();
        echo "</pre>";
        header("Location:$currentPage");
        exit();
    } 
    $data =[
        "name"=>$userName,
        "email"=>$userEmail,
        "comment"=>$commentText,
        "post_id"=>$postId,
        "parent_id"=>$parent_id
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
    $commentId = intval($data['comment_id']); // Ensuring ID is treated as an integer
    $parentId = intval($data['parent_id']);
    $db = new Database();
     if ($parentId == 0) {
        // Parent comment - delete the comment and all child comments
        $result = $db->deleteAllChildren('comment', $commentId); // Custom method to delete all child comments
    } else {
        // Child comment - delete only the specific child comment
        $result = $db->delete('comment', ['id' => $commentId]);
    }
    if ($result === "Record deleted successfully") {
        echo json_encode(['success' => true, 'message' => 'Category deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'error' => $result]);
    }
    exit();
}

?>