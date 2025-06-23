<?php
class ReportController {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        // Tổng số sản phẩm bán được
        $stmt = $this->db->prepare("SELECT SUM(quantity) as total_sold FROM sold_products");
        $stmt->execute();
        $total_sold = $stmt->fetchColumn();

        // Tổng doanh thu
        $stmt = $this->db->prepare("SELECT SUM(quantity * sale_price) as total_revenue FROM sold_products");
        $stmt->execute();
        $total_revenue = $stmt->fetchColumn();

        // Sản phẩm bán chạy nhất
        $stmt = $this->db->prepare("SELECT p.name, SUM(s.quantity) as sold_qty FROM sold_products s JOIN products p ON s.product_id = p.id GROUP BY s.product_id ORDER BY sold_qty DESC LIMIT 1");
        $stmt->execute();
        $best_seller = $stmt->fetch(PDO::FETCH_ASSOC);

        $group_by = isset($_GET['group_by']) ? $_GET['group_by'] : 'day';
        switch ($group_by) {
            case 'week':
                $date_format = "%x-%v"; // ISO year-week
                $label_format = "CONCAT('Tuần ', WEEK(sale_date), ' - ', YEAR(sale_date))";
                break;
            case 'month':
                $date_format = "%Y-%m";
                $label_format = "DATE_FORMAT(sale_date, '%m/%Y')";
                break;
            case 'year':
                $date_format = "%Y";
                $label_format = "YEAR(sale_date)";
                break;
            default:
                $date_format = "%Y-%m-%d";
                $label_format = "DATE_FORMAT(sale_date, '%d/%m/%Y')";
                break;
        }

        // Lấy danh sách tất cả danh mục (để dùng cho dropdown filter)
        include_once 'models/Category.php'; // Đảm bảo include Category model
        $category_model = new Category($this->db);
        $all_categories = $category_model->getAll();

        // Lấy ID danh mục từ filter
        $category_filter_id = isset($_GET['category_filter']) ? intval($_GET['category_filter']) : 0;

        // Lấy tất cả các mốc thời gian có bán hàng (có thể cần lọc theo danh mục nếu dữ liệu quá lớn)
        // Hiện tại giữ nguyên để đảm bảo tất cả mốc thời gian hiển thị
        $stmt = $this->db->prepare("SELECT DISTINCT DATE_FORMAT(sale_date, '$date_format') as time_group, $label_format as label FROM sold_products ORDER BY time_group");
        $stmt->execute();
        $time_groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Lấy danh sách sản phẩm (chỉ lấy sản phẩm thuộc danh mục đã lọc nếu có)
        $product_query = "SELECT id, name FROM products ";
        $params = [];
        if ($category_filter_id > 0) {
            $product_query .= " WHERE category_id = :cid";
            $params[':cid'] = $category_filter_id;
        }
        $product_query .= " ORDER BY name";

        $stmt = $this->db->prepare($product_query);
        $stmt->execute($params);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Lấy số lượng bán theo từng sản phẩm và từng mốc thời gian (chỉ các sản phẩm đã lọc)
        $product_sales = [];
        if (!empty($products)) { // Chỉ chạy nếu có sản phẩm sau khi lọc
            foreach ($products as $product) {
                $stmt = $this->db->prepare("
                    SELECT DATE_FORMAT(sale_date, '$date_format') as time_group, SUM(quantity) as qty
                    FROM sold_products
                    WHERE product_id = :pid
                    GROUP BY time_group
                ");
                $stmt->execute([':pid' => $product['id']]);
                $sales = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // [time_group => qty]
                $product_sales[] = [
                    'name' => $product['name'],
                    'data' => $sales
                ];
            }
        }

        // Chuẩn hóa dữ liệu cho JS
        $labels = array_column($time_groups, 'label');
        $chart_datasets = [];
        foreach ($product_sales as $prod) {
            $data = [];
            foreach ($time_groups as $tg) {
                $key = $tg['time_group'];
                $data[] = isset($prod['data'][$key]) ? (int)$prod['data'][$key] : 0;
            }
            $chart_datasets[] = [
                'label' => $prod['name'],
                'data' => $data,
            ];
        }

        // Lấy doanh thu từng sản phẩm (quantity*sale_price)
        $product_revenue_sql = "
            SELECT p.name as product_name, SUM(s.quantity * s.sale_price) as revenue
            FROM sold_products s
            JOIN products p ON s.product_id = p.id
            GROUP BY s.product_id, p.name
            ORDER BY revenue DESC
        ";
        $stmt = $this->db->prepare($product_revenue_sql);
        $stmt->execute();
        $product_revenue_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $product_revenue_chart = [
            'labels' => [],
            'revenue' => []
        ];
        foreach ($product_revenue_data as $row) {
            $product_revenue_chart['labels'][] = $row['product_name'];
            $product_revenue_chart['revenue'][] = (float)$row['revenue'];
        }

        // Lấy dữ liệu doanh thu theo group_by và category_filter
        $revenue_labels = [];
        $revenue_data = [];
        if ($category_filter_id > 0) {
            $revenue_sql = "SELECT DATE_FORMAT(s.sale_date, '$date_format') as time_group, $label_format as label, SUM(s.quantity * s.sale_price) as revenue
                            FROM sold_products s
                            JOIN products p ON s.product_id = p.id
                            WHERE p.category_id = :cid
                            GROUP BY time_group, label
                            ORDER BY time_group";
            $stmt = $this->db->prepare($revenue_sql);
            $stmt->execute([':cid' => $category_filter_id]);
        } else {
            $revenue_sql = "SELECT DATE_FORMAT(sale_date, '$date_format') as time_group, $label_format as label, SUM(quantity * sale_price) as revenue
                            FROM sold_products
                            GROUP BY time_group, label
                            ORDER BY time_group";
            $stmt = $this->db->prepare($revenue_sql);
            $stmt->execute();
        }
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $revenue_labels[] = $row['label'];
            $revenue_data[] = (float)$row['revenue'];
        }

        // Lấy bảng tồn kho
        $page = isset($_GET['inv_page']) ? max(1, intval($_GET['inv_page'])) : 1;
        $per_page = 10;
        $offset = ($page - 1) * $per_page;

        $inventory_category = isset($_GET['inventory_category']) ? intval($_GET['inventory_category']) : 0;
        $params = [];
        $sql_count = "SELECT COUNT(*) FROM products";
        if ($inventory_category > 0) {
            $sql_count .= " WHERE category_id = :catid";
            $params[':catid'] = $inventory_category;
        }
        $stmt = $this->db->prepare($sql_count);
        $stmt->execute($params);
        $total_inventory = $stmt->fetchColumn();
        $total_pages = ceil($total_inventory / $per_page);

        $sql = "SELECT 
                    p.id, 
                    p.name, 
                    p.quantity AS so_luong_nhap,
                    COALESCE(SUM(s.quantity), 0) AS so_luong_ban,
                    (p.quantity - COALESCE(SUM(s.quantity), 0)) AS ton_kho
                FROM products p
                LEFT JOIN sold_products s ON p.id = s.product_id";
        if ($inventory_category > 0) {
            $sql .= " WHERE p.category_id = :catid";
        }
        $sql .= " GROUP BY p.id, p.name, p.quantity ORDER BY p.id LIMIT $per_page OFFSET $offset";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include 'views/reports/index.php';
    }
} 