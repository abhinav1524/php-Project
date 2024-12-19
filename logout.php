<?php
session_start(); // Start session to access session data

require_once 'Db.php'; // Include your Database class
require_once 'loginuser.php';
$user = new loginuser(); // Initialize the loginuser class
$user->logout(); // Call the logout method to clear session data
header("Location: index.php"); // Redirect to homepage or any page you wish after logout
exit();
?>
