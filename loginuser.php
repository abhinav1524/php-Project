<?php
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
                $this->errors["email"] = "Email is required";
            }
            if (empty($password)) {
                $this->errors["password"] = "Password is required";
            }

            if (empty($this->errors)) {
                $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result(); // Fetch the result
                $user = $result->fetch_assoc(); // Get user data
                // echo "<pre>";
                // echo "Query Result:\n";
                // print_r($result);
                // die();
                // echo "<pre>";
                // print_r($user);
                // die();
                // echo "</pre>";
                if ($user && password_verify($password, $user["password"])) {
                    session_start();
                    $_SESSION["user"] = $user; // Store user info in session
                    if ($user["role"] == "admin") {
                        header("Location: admin/dashboard.php");
                    } else {
                        header("Location: index.php"); 
                        exit();
                    }
                } else {
                    $this->errors["login"] = "Invalid email or password";
                }

                $stmt->close();
            }
        }
        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }
    public function logout() {
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session
    }
}

// Example of using this in the login page
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
?>
