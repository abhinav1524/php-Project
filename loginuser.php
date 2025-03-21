<?php
session_start(); // Start session at the beginning
require_once 'Db.php'; // Include your Database file

class loginuser {
    private $db;
    private $errors = [];

    public function __construct() {
        $this->db = new Database();
    }

    public function login($email, $password) {
        $conn = $this->db->getConnection();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($email)) {
                $this->errors[] = "Email is required";
            }
            if (empty($password)) {
                $this->errors[] = "Password is required";
            }

            if (empty($this->errors)) {
                $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();

                if ($user && password_verify($password, $user["password"])) {
                    $_SESSION["user"] = $user; // Store user info in session
                    if ($user["role"] == "admin") {
                        header("Location: admin/dashboard.php");
                    } else {
                        header("Location: index.php");
                    }
                    exit();
                } else {
                    $this->errors[] = "Invalid email or password";
                }
                $stmt->close();
            }
        }

        $_SESSION['errors'] = $this->errors; // Store errors in session
        header("Location: login.php"); // Redirect back to login page
        exit();
    }
     public function getErrors() {
        return $this->errors;
    }
    public function logout() {
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new loginuser();
    $email = $_POST['email'];
    $password = $_POST['password'];

if ($user->login($email, $password)) {
        alert("you logged in successfully");
    } else {
        $errors = $user->getErrors(); // Get the errors
    }
}
