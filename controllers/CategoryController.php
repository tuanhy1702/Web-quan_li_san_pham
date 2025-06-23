<?php
include_once 'config/database.php';
include_once 'models/Category.php';

class CategoryController {
    private $db;
    private $category;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->category = new Category($this->db);
    }

    // Hiển thị danh sách danh mục
    public function index() {
        $categories = $this->category->getAll();
        include 'views/categories/index.php';
    }

    // Hiển thị form thêm danh mục mới
    public function create() {
        $message = '';
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $description = $_POST['description'] ?? '';

            if ($this->category->create($name, $description)) {
                $message = "<div class='alert alert-success' style='position: fixed; top: 20px; right: 20px; z-index: 1000;'>
                        <i class='fas fa-check-circle'></i> Thêm danh mục thành công!
                      </div>
                      <script>
                        setTimeout(function() {
                            window.location.href = 'index.php?action=categories';
                        }, 1000);
                      </script>";
            } else {
                $message = "<div class='alert alert-danger'>Thêm danh mục thất bại.</div>";
            }
        }
        
        include 'views/categories/create.php';
    }

    // Hiển thị form chỉnh sửa danh mục
    public function edit() {
        $message = '';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        if ($id > 0) {
            $category = $this->category->getById($id);
            
            if ($category) {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name = $_POST['name'];
                    $description = $_POST['description'] ?? '';

                    if ($this->category->update($id, $name, $description)) {
                        $message = "<div class='alert alert-success'>Cập nhật danh mục thành công!</div>";
                        header("refresh:1;url=index.php?action=categories");
                        exit();
                    } else {
                        $message = "<div class='alert alert-danger'>Cập nhật danh mục thất bại.</div>";
                    }
                }
                
                include 'views/categories/edit.php';
            } else {
                $message = "<div class='alert alert-danger'>Không tìm thấy danh mục!</div>";
                header("refresh:1;url=index.php?action=categories");
                exit();
            }
        } else {
            header("Location: index.php?action=categories");
            exit();
        }
    }

    // Xóa danh mục
    public function delete() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        if ($id > 0) {
            if ($this->category->delete($id)) {
                $message = "<div class='alert alert-success'>Xóa danh mục thành công!</div>";
            } else {
                $message = "<div class='alert alert-danger'>Xóa danh mục thất bại.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>ID danh mục không hợp lệ!</div>";
        }
        
        header("Location: index.php?action=categories&message=" . urlencode(strip_tags($message)));
        exit();
    }
}
?> 