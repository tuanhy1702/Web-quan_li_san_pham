<?php

class Product {
    private $conn;
    private $table_name = "products";

    // Thuộc tính của đối tượng
    public $id;
    public $name;
    public $description;
    public $purchase;
    public $price;
    public $quantity;
    public $image;
    public $category_id;
    public $created_at;
    public $updated_at;
    public $expiration_date;

    // Hàm khởi tạo với $db là kết nối cơ sở dữ liệu
    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách sản phẩm
    public function read($sort = '') {
        $order = $this->getOrderBy($sort);
        $query = "SELECT
                    p.id, p.name, p.description, p.purchase, p.price, p.quantity, p.image, p.category_id, p.created_at, p.updated_at, p.expiration_date,
                    c.name as category_name
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categories c ON p.category_id = c.id
                $order";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Đếm tổng số lượng sản phẩm (dùng cho phân trang)
    public function count(){
        $query = "SELECT SUM(quantity) as total_quantity FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Trả về tổng số lượng
        return $row['total_quantity'];
    }

    // Tính tổng giá trị của tất cả sản phẩm
    public function getTotalValue(){
        $query = "SELECT SUM(quantity * price) as total_value FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Trả về tổng giá trị
        return $row['total_value'] ? $row['total_value'] : 0;
    }

    // Đếm số sản phẩm sắp hết hạn (trong vòng 10 ngày) (product)
    public function getExpiringProducts() {
        $query = "SELECT COUNT(*) as expiring_count FROM " . $this->table_name . 
                " WHERE expiration_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 10 DAY)";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['expiring_count'] ? $row['expiring_count'] : 0;
    }

    // Lấy danh sách sản phẩm sắp hết hạn (product)
    public function getExpiringProductsList() {
        $query = "SELECT id, name, expiration_date, quantity FROM " . $this->table_name . 
                " WHERE expiration_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 10 DAY)
                ORDER BY expiration_date ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy dữ liệu sản phẩm cho biểu đồ số lượng (product)
    public function getProductsForChart() {
        $query = "SELECT name, quantity FROM " . $this->table_name . " ORDER BY quantity DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy dữ liệu sản phẩm cho biểu đồ giá trị (tên, số lượng, giá)
    public function getProductsValueForChart() {
        $query = "SELECT name, quantity, price FROM " . $this->table_name . " ORDER BY (quantity * price) DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách sản phẩm có số lượng tồn kho dưới 50
    // public function getLowStockProducts() {
    //     $query = "SELECT name, quantity FROM " . $this->table_name .
    //              " WHERE quantity < 50 ORDER BY quantity ASC";

    //     $stmt = $this->conn->prepare($query);
    //     $stmt->execute();

    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    // Lấy danh sách sản phẩm có số lượng tồn kho dưới 50
    public function getLowStockProducts() {
        $query = "SELECT
                    p.id,
                    p.name,
                    p.quantity AS total_quantity,
                    COALESCE(SUM(sp.quantity), 0) AS sold_quantity,
                    (p.quantity - COALESCE(SUM(sp.quantity), 0)) AS remaining_stock
                  FROM
                    " . $this->table_name . " p
                  LEFT JOIN
                    sold_products sp ON p.id = sp.product_id
                  GROUP BY
                    p.id, p.name, p.quantity
                  HAVING
                    (p.quantity - COALESCE(SUM(sp.quantity), 0)) < 50
                  ORDER BY
                    remaining_stock ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tìm kiếm sản phẩm theo tên
    public function searchByName($name) {
        $query = "SELECT p.*, c.name as category_name
                  FROM products p
                  LEFT JOIN categories c ON p.category_id = c.id
                  WHERE p.name LIKE :name
                  ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($query);
        $like = '%' . $name . '%';
        $stmt->bindParam(':name', $like);
        $stmt->execute();
        return $stmt;
    }

    // Tìm kiếm sản phẩm theo danh mục
    public function searchByCategory($category_id) {
        $query = "SELECT p.*, c.name as category_name
                  FROM products p
                  LEFT JOIN categories c ON p.category_id = c.id
                  WHERE p.category_id = :category_id
                  ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Tìm kiếm sản phẩm theo tên và danh mục
    public function searchByNameAndCategory($name, $category_id) {
        $query = "SELECT p.*, c.name as category_name
                  FROM products p
                  LEFT JOIN categories c ON p.category_id = c.id
                  WHERE p.name LIKE :name AND p.category_id = :category_id
                  ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($query);
        $like = '%' . $name . '%';
        $stmt->bindParam(':name', $like);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Lấy câu lệnh ORDER BY phù hợp với kiểu sắp xếp
    private function getOrderBy($sort) {
        switch ($sort) {
            case 'quantity_desc':
                return "ORDER BY p.quantity DESC";
            case 'quantity_asc':
                return "ORDER BY p.quantity ASC";
            case 'name_asc':
                return "ORDER BY p.name ASC";
            case 'name_desc':
                return "ORDER BY p.name DESC";
            default:
                return "ORDER BY p.created_at DESC";
        }
    }

    // Lấy danh sách sản phẩm có phân trang
    public function readWithPagination($page = 1, $records_per_page = 6, $sort = '') {
        $order = $this->getOrderBy($sort);
        $offset = ($page - 1) * $records_per_page;
        
        $query = "SELECT
                    p.id, p.name, p.description, p.purchase, p.price, p.quantity, p.image, p.category_id, p.created_at, p.updated_at, p.expiration_date,
                    c.name as category_name
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categories c ON p.category_id = c.id
                $order
                LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $records_per_page, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Lấy tổng số sản phẩm (product)
    public function getTotalProducts() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
?> 