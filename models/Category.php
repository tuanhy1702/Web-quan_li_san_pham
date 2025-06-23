<?php
class Category {
    private $conn;
    private $table_name = "categories";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy tất cả danh mục
    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh mục theo ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm danh mục mới
    public function create($name, $description = '') {
        $query = "INSERT INTO " . $this->table_name . " (name, description, created_at) 
                  VALUES (:name, :description, NOW())";
        
        $stmt = $this->conn->prepare($query);
        
        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        
        // Bind các giá trị
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        
        // Thực thi query
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Cập nhật danh mục
    public function update($id, $name, $description = '') {
        $query = "UPDATE " . $this->table_name . "
                  SET name = :name, description = :description
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        
        // Bind các giá trị
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":id", $id);
        
        // Thực thi query
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Xóa danh mục
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
