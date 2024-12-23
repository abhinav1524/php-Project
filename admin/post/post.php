<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../../Db.php';
// die("reached the post.php file");
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
//getting all data //
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['fetchAll'])) {
    // Create a new instance of the Database class
    $db = new Database();
    $tableName = 'posts';
    echo $db->getAllData($tableName); // Fetch and return table data in JSON format
    header('Content-Type: application/json');
    exit;
}
// insert code //
   if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['insert'])){
    $db =new Database();
    echo "instance is created";
    $title =$_POST['title']??'';
    $content =$_POST['content']??'';
    $category =$_POST['category']??'';
    $image =$_FILES['image']??null;
    // echo "<pre>";
    // print_r($title);
    // print_r($content);
    // print_r($image);
    // die();
    // echo "</pre>";
    if(empty($title)||empty($content)||empty($image)){
        $_SESSION['error']= "all field is required";
        header("Location:./index.php");
        exit();
    }
     // Handle file upload
    $uploadDir = dirname(__DIR__, 2).'/images/';
    $imageName = basename($image['name']);
    $targetFilePath = $uploadDir . $imageName;
    // Normalize the path to prevent extra slashes
    $targetFilePath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $targetFilePath);
    if (move_uploaded_file($image['tmp_name'], $targetFilePath)) {
        echo "i get in move_uploaded_file condition";
        $data=[
            'title'=>$title,
            'content'=>$content,
            'category_id'=>$category,
            'image'=>$targetFilePath,
        ];
        $result=$db->insert('posts', $data);
        if($result==="Record inserted successfully"){
            $_SESSION['success'] ="Post added successfully";
            header('Location:./index.php');
        }else{
            $_SESSION['error']= $result;
            header("Location:./index.php");
        }
}else {
        $_SESSION['error'] = "Failed to upload image.";
        header("Location: ./index.php");
    }
    exit();
   }
   // update code //
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $db = new Database();
    $id = $_POST['id'] ?? '';
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $category = $_POST['category'] ?? '';
    $image = $_FILES['image'] ?? null;
    
    // If no image is provided, keep the old image
    if (!empty($image['name'])) {
        // Handle new image upload
        $imageName = basename($image['name']);
        $targetFilePath = dirname(__DIR__, 2) . '/images/' . $imageName;

        // Normalize the path
        $targetFilePath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $targetFilePath);
        
        if (move_uploaded_file($image['tmp_name'], $targetFilePath)) {
            // If there is a previous image, remove it
            $previousImage = $db->getOne('posts', ['id' => $id], 'image')['image'] ?? null;
            if ($previousImage && file_exists($previousImage)) {
                unlink($previousImage);  // Remove old image
            }
            $data = [
                'title' => $title,
                'content' => $content,
                'category_id' => $category,
                'image' => $targetFilePath
            ];
        } else {
            $_SESSION['error'] = "Failed to upload image.";
            header("Location: ./index.php");
            exit();
        }
    } else {
        // If no new image, use the old one
        $previousImage = $db->getOne('posts', ['id' => $id], 'image')['image'] ?? null;
        $data = [
            'title' => $title,
            'content' => $content,
            'category_id' => $category,
            'image' => $previousImage  // Use the old image from the database
        ];
    }

    $result = $db->update('posts', $data, ['id' => $id]);

    if ($result === "Record updated successfully") {
        $_SESSION['success'] = "Post updated successfully.";
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
    $db = new Database();
    $post = $db->getOne('posts', ['id' => $id]); // Assuming you have this getOne function
    // Check if the image exists and delete it
    if (file_exists($post['image'])) {
        unlink($post['image']); // Delete the file
    }
    // Call the delete function
    $result = $db->delete('posts', ['id' => $id]);
    if ($result === "Record deleted successfully") {
        echo json_encode(['success' => true, 'message' => 'Post deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'error' => $result]);
    }
    
    exit();
}


?>