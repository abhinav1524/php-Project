<?php
session_start(); 
// Check if user is logged in
$isLoggedIn = isset($_SESSION['user']);
require './Db.php';

$userId = $_SESSION['id']; // Replace with the actual logged-in user ID
// Action to record
$action = "User logged in";

// Insert activity into user_activity table
$sql = "INSERT INTO user_activity (user_id, action) VALUES (?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("is", $userId, $action);

if ($stmt->execute()) {
    echo "Activity recorded successfully.";
} else {
    echo "Error recording activity: " . $stmt->error;
}
?>