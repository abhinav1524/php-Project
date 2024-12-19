<?php
session_start();
require_once '../../Db.php';

class category{
    private $db;
    private $errors =[];
    public function __construct(){
        $this->db =new Database();
    }
    private function generateSlug($string) {
        $slug = strtolower($string); // Convert to lowercase
        $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug); // Replace non-alphanumeric characters with hyphens
        $slug = trim($slug, '-'); // Trim hyphens from the beginning and end
        return $slug;
    }
    // getting all the categories //
    public function getAllCategories() {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare('SELECT * FROM categories');
        $stmt->execute();
        $result = $stmt->get_result();
        $categories = $result->fetch_all(MYSQLI_ASSOC); // Fetch all as associative array
        $stmt->close();
        return $categories;
    }
    // adding the categories code //
    public function addcategory($name){
        $conn =$this->db->getConnection();
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(empty($name)){
                $this->errors["name"] = "Name is required";
            }
            $slug=$this->generateSlug($name);
            if(empty($this->errors)){
                $stmt = $conn->prepare('INSERT INTO categories (name, slug) VALUES (?, ?)');
                $stmt->bind_param('ss', $name, $slug);
                if ($stmt->execute()) {
                    return true; // Successfully added
                } else {
                    $this->errors['db'] = 'Failed to add category';
                }
                $stmt->close();
            }
        }
        return false;
    }
    // getting the data which should be update //
    public function getCategoryById($id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare('SELECT * FROM categories WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $category = $result->fetch_assoc(); // Fetch single row as associative array
        $stmt->close();
        return $category;
    }
    // updating the data //
    public function updateCategory($id, $name) {
        $conn = $this->db->getConnection();
        $slug = $this->generateSlug($name); // Generate slug based on the name
        $stmt = $conn->prepare('UPDATE categories SET name = ?, slug = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?');
        $stmt->bind_param('ssi', $name, $slug, $id);
        if ($stmt->execute()) {
            return true; // Successfully updated
        } else {
            $this->errors['db'] = 'Failed to update category';
            $stmt->close();
            return false;
        }
        $stmt->close();
    }
    // delete the data //
    public function deleteCategory($id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare('DELETE FROM categories WHERE id = ?');
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            return true; // Successfully deleted
        } else {
            $this->errors['db'] = 'Failed to delete category';
            $stmt->close();
            return false;
        }
        $stmt->close();
    }
     public function getErrors() {
        return $this->errors;
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = new category();
    $name = $_POST['name'] ?? '';

    if ($category->addcategory($name)) {
        header('Location: ./index.php'); // Redirect on successful registration
        exit();
    } else {
        $_SESSION['errors'] = $category->getErrors(); // Store errors in session
        header('Location: ./index.php'); // Redirect back to form with errors
        exit();
    }
} 
?>