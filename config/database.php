<?php
// Bật hiển thị lỗi
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Database {
    private $host = "localhost";
    private $db_name = "product_management";
    private $username = "root";
    private $password = "";  // Nếu bạn đã đặt mật khẩu cho MySQL, hãy điền vào đây
    private $port = "3308";  // Port mặc định của MySQL
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $e) {
            echo "Lỗi kết nối: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>
