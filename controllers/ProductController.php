<?php

// Include database and object files
include_once 'config/database.php';
include_once 'models/Product.php';
include_once 'models/Category.php';

class ProductController {
    private $db;
    private $product;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->product = new Product($this->db);
    }

    // Danh sách sản phẩm
    public function index() {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $category_filter = isset($_GET['category_filter']) ? $_GET['category_filter'] : '';
        $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $records_per_page = 6;

        if ($search !== '' && $category_filter !== '') {
            $stmt = $this->product->searchByNameAndCategory($search, $category_filter, $sort);
        } elseif ($search !== '') {
            $stmt = $this->product->searchByName($search, $sort);
        } elseif ($category_filter !== '') {
            $stmt = $this->product->searchByCategory($category_filter, $sort);
        } else {
            $stmt = $this->product->readWithPagination($page, $records_per_page, $sort);
        }
        $num = $stmt->rowCount();

        // lấy tổng số lượng sản phẩm
        $total_products = $this->product->getTotalProducts();
        
        // tính tổng số trang
        $total_pages = ceil($total_products / $records_per_page);
        
        // lấy tổng giá trị sản phẩm
        $total_value = $this->product->getTotalValue();

        // lấy số lượng sản phẩm sắp hết hạn
        $expiring_products = $this->product->getExpiringProducts();
        
        // lấy danh sách sản phẩm sắp hết hạn
        $expiring_products_list = $this->product->getExpiringProductsList();

        // lấy dữ liệu sản phẩm cho biểu đồ
        $products_for_chart = $this->product->getProductsForChart();

        // lấy dữ liệu giá trị sản phẩm cho biểu đồ
        $products_value_for_chart = $this->product->getProductsValueForChart();

        // lấy danh sách sản phẩm có số lượng dưới 30
        $low_stock_products_list = $this->product->getLowStockProducts();
        $low_stock_count = count($low_stock_products_list);

        $categoryModel = new Category($this->db);
        $all_categories = $categoryModel->getAll();

        // bao gồm view danh sách sản phẩm
        include 'views/products/index.php';
    }

    public function create() {
        $message = '';
        // Sử dụng model Category để lấy danh mục
        $categoryModel = new Category($this->db);
        $categories = $categoryModel->getAll();

        

        // Xử lý khi submit form
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $purchase = $_POST['purchase'];
            $quantity = $_POST['quantity'];
            $unit = $_POST['unit'];
            $category_id = $_POST['category_id'];
            $expiration_date = $_POST['expiration_date'];

            // Xử lý upload ảnh
            $image = '';
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "uploads/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                $new_filename = uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $new_filename;
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image = $target_file;
                }
            }

            // Lưu vào database
            $query = "INSERT INTO products (name, description, price, purchase, quantity, unit, category_id, image, expiration_date, created_at) 
                      VALUES (:name, :description, :price, :purchase, :quantity, :unit, :category_id, :image, :expiration_date, NOW())";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':purchase', $purchase);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':unit', $unit);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':expiration_date', $expiration_date);

            if($stmt->execute()) {
                $message = "<div class='alert alert-success'>Thêm sản phẩm thành công!</div>";
                header("refresh:2;url=index.php");
                exit();
            } else {
                $message = "<div class='alert alert-danger'>Thêm sản phẩm thất bại.</div>";
            }
        }
        
        include 'views/products/create.php';
    }

    public function edit() {
        $message = '';
        $categoryModel = new Category($this->db);
        $categories = $categoryModel->getAll();

        // Lấy id sản phẩm từ URL
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // Lấy thông tin sản phẩm
        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            $message = "<div class='alert alert-danger'>Không tìm thấy sản phẩm!</div>";
            include 'views/products/edit.php';
            return;
        }

        // Xử lý khi submit form
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $purchase = $_POST['purchase'];
            $quantity = $_POST['quantity'];
            $unit = $_POST['unit'];
            $category_id = $_POST['category_id'];
            $expiration_date = $_POST['expiration_date'];

            // Xử lý upload ảnh (nếu có)
            $image = $product['image'];
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "uploads/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                $new_filename = uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $new_filename;
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image = $target_file;
                }
            }

            // Cập nhật vào database
            $query = "UPDATE products SET name=:name, description=:description, price=:price, purchase=:purchase, quantity=:quantity, unit=:unit, category_id=:category_id, image=:image, expiration_date=:expiration_date WHERE id=:id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':purchase', $purchase);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':unit', $unit);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':expiration_date', $expiration_date);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if($stmt->execute()) {
                $message = "<div class='alert alert-success'>Cập nhật sản phẩm thành công!</div>";
                echo "<meta http-equiv='refresh' content='1;url=index.php'>";
                // Hiển thị lại form với thông báo thành công
                include 'views/products/edit.php';
                exit();
            } else {
                $message = "<div class='alert alert-danger'>Cập nhật sản phẩm thất bại.</div>";
            }
        }

        include 'views/products/edit.php';
    }

    public function delete() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $message = '';

        if ($id > 0) {
            $query = "DELETE FROM products WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $message = "<div class='alert alert-success'>Xóa sản phẩm thành công!</div>";
            } else {
                $message = "<div class='alert alert-danger'>Xóa sản phẩm thất bại.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>ID sản phẩm không hợp lệ!</div>";
        }

        // Sau khi xóa, quay về trang danh sách và hiển thị thông báo
        // Có thể truyền $message qua session hoặc query string, ở đây đơn giản là reload lại index
        header("Location: index.php?message=" . urlencode(strip_tags($message)));
        exit();
    }

}

?> 