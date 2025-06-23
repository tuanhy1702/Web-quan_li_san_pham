<?php
session_start();
require_once 'config/database.php';

// Include the Product Controller
include_once 'controllers/ProductController.php';
include_once 'controllers/CategoryController.php';
include_once 'controllers/ReportController.php';

// Simple routing (for now, default to ProductController index)
// In a real application, you would parse the URL to determine the controller and action

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Kiểm tra đăng nhập cho các trang cần xác thực
$public_pages = ['login', 'register'];
if (!in_array($action, $public_pages) && !isset($_SESSION['user_id'])) {
    header("Location: ./auth/login.php");
    exit();
}

$productController = new ProductController();
$categoryController = new CategoryController();
$reportController = null;

switch($action) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $database = new Database();
            $conn = $database->getConnection();
            
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['fullname'];
                    $_SESSION['user_role'] = $user['role'];
                    header("Location: ./index.php");
                    exit();
                }
            }
            $error = "Email hoặc mật khẩu không đúng";
            include './auth/login.php';
        } else {
            include './auth/login.php';
        }
        break;

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $fullname = $_POST['firstname'] . ' ' . $_POST['lastname'];
            $birthdate = $_POST['birthdate'];
            $gender = $_POST['gender'];
            $city = $_POST['city'];
            $hobbies = isset($_POST['hobbies']) ? implode(',', $_POST['hobbies']) : '';
            $description = $_POST['description'];
            $role = 'user'; // Mặc định là user

            $database = new Database();
            $conn = $database->getConnection();

            try {
                $sql = "INSERT INTO users (username, password, email, fullname, role, birthdate, gender, city, hobbies, description) 
                        VALUES (:email, :password, :email, :fullname, :role, :birthdate, :gender, :city, :hobbies, :description)";
                
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':fullname', $fullname);
                $stmt->bindParam(':role', $role);
                $stmt->bindParam(':birthdate', $birthdate);
                $stmt->bindParam(':gender', $gender);
                $stmt->bindParam(':city', $city);
                $stmt->bindParam(':hobbies', $hobbies);
                $stmt->bindParam(':description', $description);

                if ($stmt->execute()) {
                    header("Location: ./auth/login.php");
                    exit();
                }
            } catch(PDOException $e) {
                $error = "Lỗi đăng ký: " . $e->getMessage();
                include './auth/register.php';
            }
        } else {
            include './auth/register.php';
        }
        break;

    case 'logout':
        session_destroy();
        header("Location: ./index_marketing.php");
        exit();
        break;

    case 'index':
        $productController->index();
        break;
    case 'create':
        $productController->create();
        break;
    case 'edit':
        $productController->edit();
        break;
    case 'delete':
        $productController->delete();
        break;
    case 'categories':
        $categoryController->index();
        break;
    case 'create_category':
        $categoryController->create();
        break;
    case 'edit_category':
        $categoryController->edit();
        break;
    case 'delete_category':
        $categoryController->delete();
        break;
    case 'reports':
        if (!$reportController) {
            $database = new Database();
            $db = $database->getConnection();
            $reportController = new ReportController($db);
        }
        $reportController->index();
        break;
    default:
        $productController->index();
        break;
}
?>