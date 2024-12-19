<?php
session_start();
require_once 'Db.php';

class User {
    private $db;
    private $errors = [];

    public function __construct() {
        $this->db = new Database();
    }

    public function register($username, $password, $email, $phone) {
        $conn = $this->db->getConnection();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($username)) {
                $this->errors['username'] = 'Username is required';
            }
            if (empty($password)) {
                $this->errors['password'] = 'Password is required';
            }
            if (empty($email)) {
                $this->errors['email'] = 'Email is required';
            }
            if (empty($phone)) {
                $this->errors['phone'] = 'Phone number is required';
            }

            if (empty($this->errors)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare('INSERT INTO users (name, password, email, phone) VALUES (?, ?, ?, ?)');
                $stmt->bind_param('ssss', $username, $hashed_password, $email, $phone);

                if ($stmt->execute()) {
                    return true;
                } else {
                    $this->errors['db'] = 'Database error. Please try again.';
                }

                $stmt->close();
            }
        }

        return false;
    }

    public function getErrors() {
        return $this->errors;
    }
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User();
    $name = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if ($user->register($name, $password, $email, $phone)) {
        header('Location: login.php'); // Redirect on successful registration
        exit();
    } else {
        $_SESSION['errors'] = $user->getErrors(); // Store errors in session
        header('Location: register.php'); // Redirect back to form with errors
        exit();
    }
}
?>
