<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sản phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: sans-serif;
            background-color: #fffbe6; /* Vàng nhạt */
        }
        .wrapper {
            display: flex;
        }
        .sidebar {
            width: 210px;
            min-width: 200px; /* Thêm min-width để đảm bảo độ rộng tối thiểu */
            max-width: 220px; /* Thêm max-width để đảm bảo độ rộng tối đa */
            background-color: #004085;
            color: #ffffff;
            height: 100vh;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            position: fixed; /* Thêm position fixed */
            left: 0; /* Cố định vị trí bên trái */
            top: 0; /* Cố định vị trí phía trên */
        }
        .sidebar a {
            color: #cce5ff; /* Lighter blue for links */
            padding: 12px 15px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s ease;
        }
        .sidebar a:hover {
            background-color: #0056b3; /* Medium blue on hover */
            color: #ffffff;
        }
        .sidebar .active {
            background-color: #007bff; /* Bootstrap primary blue */
            color: #ffffff;
        }
        .sidebar h4 {
            color: #ffffff;
            margin-bottom: 30px;
        }
        .main-content {
            flex-grow: 1;
            padding: 10px;
            margin-left: 220px; /* Điều chỉnh margin-left bằng với max-width của sidebar */
        }
        .container-fluid {
            padding: 0;
            margin: 0;
            width: 100%;
        }
        .row {
            margin: 0;
            padding: 0;
        }
        .col-md-4, .col-md-2 {
            padding: 5px;
        }
        .card {
            margin-bottom: 10px;
        }
        .table {
            margin-top: 10px;
            border-radius: 16px !important;
            overflow: hidden;
            background: #fff;
        }
        .table th, .table td {
            background: #fff;
        }
        .mb-4 {
            margin-bottom: 10px !important;
        }
        .mb-3 {
            margin-bottom: 10px !important;
        }
        .header {
            background-color: #ffffff;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .header h2 {
            margin: 0;
        }
        .card-summary {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px; /* Added margin bottom for cards */
        }
         .card {
            border: none; /* Remove card border */
            box-shadow: 0 4px 8px rgba(0,0,0,0.08); /* Add subtle shadow */
         }
        .card-summary i {
            font-size: 2.5rem; /* Slightly larger icons */
            margin-bottom: 10px;
            color: #007bff; /* Blue icons */
        }
        .card-title {
            font-size: 1.1rem;
            font-weight: bold;
        }
        .card-text {
            font-size: 1.5rem;
            color: #333;
        }
        .table th {
            background-color: #007bff; /* Blue header for table */
            color: white;
        }
        .table-hover tbody tr:hover {
            background-color: #e9ecef; /* Light grey hover effect */
        }
        /* Style for the product image in the table */
        .table img {
            max-width: 60px;
            height: auto;
            border-radius: 4px;
        }
         .btn-primary {
             background-color: #007bff;
             border-color: #007bff;
         }
         .btn-primary:hover {
             background-color: #0056b3;
             border-color: #004085;
         }
         .form-control {
             border-radius: 4px;
         }
         .input-group-append .btn {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
         }

    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <div style="text-align: center;">
                <img src="./uploads/logo.png" alt="EcoMart Logo" style="height: 50px; margin-bottom: 20px;">
            </div>
            <a href="index.php?action=index" class="active"><i class="fas fa-list"></i> Danh sách sản phẩm</a>
            <a href="index.php?action=categories"><i class="fas fa-cube"></i> Quản lý danh mục</a>
            <a href="index.php?action=reports"><i class="fas fa-chart-bar"></i> Báo cáo & Thống kê</a>
            <a href="index.php?action=logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
        </div>

        <!-- Page Content -->
        <div class="main-content">

            <!-- Main Content Area -->
            <div class="container-fluid">
                
                <!-- Summary Cards -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="card bg-info text-white" style="border-radius: 16px; transition: all 0.3s ease;">
                            <div class="card-body card-summary" 
                                 style="cursor: pointer;"
                                 data-toggle="modal" data-target="#productsChartModal"
                                 onmouseover="this.parentElement.style.transform='translateY(-5px)'; this.parentElement.style.boxShadow='0 8px 16px rgba(0,0,0,0.2)';"
                                 onmouseout="this.parentElement.style.transform='translateY(0)'; this.parentElement.style.boxShadow='0 4px 8px rgba(0,0,0,0.08)';"
                            >
                                        <i class="fas fa-boxes" style="color: white;"></i>
                                        <h5 class="card-title">Tổng sản phẩm</h5>
                                        <p class="card-text text-white"><?php echo $total_products; ?> loại</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white" style="transition: all 0.3s ease; border-radius: 16px;">
                            <div class="card-body card-summary" style="cursor: pointer;" data-toggle="modal" data-target="#productValueChartModal" onmouseover="this.parentElement.style.transform='translateY(-5px)'; this.parentElement.style.boxShadow='0 8px 16px rgba(0,0,0,0.2)';" onmouseout="this.parentElement.style.transform='translateY(0)'; this.parentElement.style.boxShadow='0 4px 8px rgba(0,0,0,0.08)';">
                                <i class="fas fa-dollar-sign"   style="color: white;"></i>
                                <h5 class="card-title">Tổng giá trị hàng hoá</h5>
                                <p class="card-text text-white"><?php echo number_format($total_value, 0, ',', '.'); ?> VNĐ</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white" style="transition: all 0.3s ease; border-radius: 16px;">
                            <div class="card-body card-summary" style="cursor: pointer;" data-toggle="modal" data-target="#lowStockProductsModal" onmouseover="this.parentElement.style.transform='translateY(-5px)'; this.parentElement.style.boxShadow='0 8px 16px rgba(0,0,0,0.2)';" onmouseout="this.parentElement.style.transform='translateY(0)'; this.parentElement.style.boxShadow='0 4px 8px rgba(0,0,0,0.08)';">
                                <i class="fas fa-exclamation-triangle"  style="color: white;"></i>
                                <h5 class="card-title">Sản phẩm sắp hết</h5>
                                <p class="card-text text-white"><?php echo $low_stock_count; ?> loại</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white" style="; transition: all 0.3s ease; border-radius: 16px;">
                            <div class="card-body card-summary" style="cursor: pointer;" data-toggle="modal" data-target="#expiringProductsModal" onmouseover="this.parentElement.style.transform='translateY(-5px)'; this.parentElement.style.boxShadow='0 8px 16px rgba(0,0,0,0.2)';" onmouseout="this.parentElement.style.transform='translateY(0)'; this.parentElement.style.boxShadow='0 4px 8px rgba(0,0,0,0.08)';">
                                <i class="fas fa-exclamation-triangle" style="color: white;"></i>
                                <h5 class="card-title">Sản phẩm sắp hết hạn</h5>
                                <p class="card-text text-white"><?php echo $expiring_products; ?> loại</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal số lượng sản phẩm -->
                <div class="modal fade" id="productsChartModal" tabindex="-1" role="dialog" aria-labelledby="productsChartModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productsChartModalLabel">Biểu đồ số lượng sản phẩm</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <canvas id="productsChart"></canvas>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal giá trị sản phẩm -->
                <div class="modal fade" id="productValueChartModal" tabindex="-1" role="dialog" aria-labelledby="productValueChartModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productValueChartModalLabel">Biểu đồ giá trị sản phẩm</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <canvas id="productValueChart"></canvas>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal sản phẩm sắp hết hạn -->
                <div class="modal fade" id="expiringProductsModal" tabindex="-1" role="dialog" aria-labelledby="expiringProductsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="expiringProductsModalLabel">Biểu đồ sản phẩm sắp hết hạn</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <canvas id="expiringProductsChart"></canvas>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal sản phẩm số lượng thấp -->
                <div class="modal fade" id="lowStockProductsModal" tabindex="-1" role="dialog" aria-labelledby="lowStockProductsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="lowStockProductsModalLabel">Biểu đồ sản phẩm số lượng thấp (< 50)</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <canvas id="lowStockProductsChart"></canvas>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tìm kiếm và bộ lọc -->
                <div class="row mb-3 align-items-center">
                    <div class="col-md-4">
                        <form method="GET" action="index.php" class="input-group">
                            <input type="hidden" name="action" value="index">
                            <input type="text" class="form-control" name="search" placeholder="Tìm kiếm sản phẩm..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i> Tìm kiếm</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <form method="GET" action="index.php">
                            <input type="hidden" name="action" value="index">
                            <?php if(isset($_GET['search'])): ?>
                                <input type="hidden" name="search" value="<?= htmlspecialchars($_GET['search']) ?>">
                            <?php endif; ?>
                            <?php if(isset($_GET['category_filter'])): ?>
                                <input type="hidden" name="category_filter" value="<?= htmlspecialchars($_GET['category_filter']) ?>">
                            <?php endif; ?>
                            <select name="sort" class="form-control" onchange="this.form.submit()">
                                <option value="">-- Sắp xếp --</option>
                                <option value="quantity_desc" <?= (isset($_GET['sort']) && $_GET['sort']=='quantity_desc') ? 'selected' : '' ?>>Số lượng giảm dần</option>
                                <option value="quantity_asc" <?= (isset($_GET['sort']) && $_GET['sort']=='quantity_asc') ? 'selected' : '' ?>>Số lượng tăng dần</option>
                                <option value="name_asc" <?= (isset($_GET['sort']) && $_GET['sort']=='name_asc') ? 'selected' : '' ?>>Tên A-Z</option>
                                <option value="name_desc" <?= (isset($_GET['sort']) && $_GET['sort']=='name_desc') ? 'selected' : '' ?>>Tên Z-A</option>
                            </select>
                        </form>
                    </div>
                    
                    <div class="col-md-2">
                        <form method="GET" action="index.php">
                            <input type="hidden" name="action" value="index">
                            <select name="category_filter" class="form-control" onchange="this.form.submit()">
                                <option value="">Tất cả danh mục</option>
                                <?php foreach ($all_categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?php if(isset($_GET['category_filter']) && $_GET['category_filter'] == $cat['id']) echo 'selected'; ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if(isset($_GET['search'])): ?>
                                <input type="hidden" name="search" value="<?= htmlspecialchars($_GET['search']) ?>">
                            <?php endif; ?>
                        </form>
                    </div>
                    
                    <div class="col-md-4 text-right">
                         <a href="index.php?action=create" class="btn btn-primary"><i class="fas fa-plus"></i> Thêm sản phẩm mới</a>
                    </div>
                </div>

                <!-- Products Table -->
                <?php
                // display products if there are any
                if($num>0){

                    echo "<table class='table table-bordered table-hover'>";
                        echo "<thead>";
                            echo "<tr>";
                                echo "<th>ID</th>";
                                echo "<th>Hình ảnh</th>"; // Thêm cột hình ảnh
                                echo "<th>Tên sản phẩm</th>";
                                echo "<th>Mô tả</th>";
                                echo "<th>Nhập</th>";
                                echo "<th>Giá</th>";
                                echo "<th>Số lượng</th>";
                                echo "<th>Danh mục</th>"; // Giữ lại cột danh mục
                                echo "<th>Ngày tạo</th>";
                                echo "<th>Ngày hết hạn</th>"; // Giữ lại cột ngày hết hạn
                                echo "<th>Thao tác</th>";
                            echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                            extract($row);

                            echo "<tr>";
                                echo "<td>{$id}</td>";
                                // Hiển thị hình ảnh sản phẩm (giả sử $image chứa đường dẫn/URL hình ảnh)
                                echo "<td><img src='{$image}' alt='Hình ảnh sản phẩm' style='width: 50px; height: auto;'></td>";
                                echo "<td>{$name}</td>";
                                echo "<td>{$description}</td>";
                                echo "<td>{$purchase} VNĐ</td>";
                                echo "<td>{$price} VNĐ</td>";
                                echo "<td>{$quantity}</td>";
                                echo "<td>{$category_name}</td>"; // Hiển thị tên danh mục
                                echo "<td>{$created_at}</td>";
                                echo "<td>{$expiration_date}</td>";
                                echo "<td>";
                                    echo "<a href='index.php?action=edit&id={$id}' class='btn btn-info btn-sm mr-1'>Sửa</a>";
                                    echo "<a href='index.php?action=delete&id={$id}' class='btn btn-danger btn-sm' onclick=\"return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');\">Xóa</a>";
                                echo "</td>";
                            echo "</tr>";

                        }

                        echo "</tbody>";
                    echo "</table>";

                    // Phân trang
                    if($total_pages > 1) {
                        echo "<div class='d-flex justify-content-center mt-4'>";
                        echo "<nav aria-label='Page navigation'>";
                        echo "<ul class='pagination'>";
                        
                        // Nút Previous
                        $prev_disabled = ($page <= 1) ? 'disabled' : '';
                        echo "<li class='page-item {$prev_disabled}'>";
                        echo "<a class='page-link' href='?page=" . ($page-1) . 
                             (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') .
                             (isset($_GET['category_filter']) ? '&category_filter=' . $_GET['category_filter'] : '') .
                             (isset($_GET['sort']) ? '&sort=' . $_GET['sort'] : '') .
                             "' aria-label='Previous'>";
                        echo "<span aria-hidden='true'>&laquo;</span>";
                        echo "</a></li>";

                        // Các số trang
                        for($i = 1; $i <= $total_pages; $i++) {
                            $active = ($i == $page) ? 'active' : '';
                            echo "<li class='page-item {$active}'>";
                            echo "<a class='page-link' href='?page={$i}" .
                                 (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') .
                                 (isset($_GET['category_filter']) ? '&category_filter=' . $_GET['category_filter'] : '') .
                                 (isset($_GET['sort']) ? '&sort=' . $_GET['sort'] : '') .
                                 "'>{$i}</a></li>";
                        }

                        // Nút Next
                        $next_disabled = ($page >= $total_pages) ? 'disabled' : '';
                        echo "<li class='page-item {$next_disabled}'>";
                        echo "<a class='page-link' href='?page=" . ($page+1) .
                             (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') .
                             (isset($_GET['category_filter']) ? '&category_filter=' . $_GET['category_filter'] : '') .
                             (isset($_GET['sort']) ? '&sort=' . $_GET['sort'] : '') .
                             "' aria-label='Next'>";
                        echo "<span aria-hidden='true'>&raquo;</span>";
                        echo "</a></li>";

                        echo "</ul>";
                        echo "</nav>";
                        echo "</div>";
                    }

                } else {
                    echo "<div class='alert alert-info'>Không tìm thấy sản phẩm nào.</div>";
                }
                ?>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Chuẩn bị dữ liệu cho biểu đồ số lượng sản phẩm 
        const productsData = <?php echo json_encode($products_for_chart); ?>;
        const labels = productsData.map(product => product.name);
        const quantities = productsData.map(product => product.quantity);

        // Biểu đồ số lượng sản phẩm
        $('#productsChartModal').on('shown.bs.modal', function () {
            const ctx = document.getElementById('productsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Số lượng sản phẩm',
                        data: quantities,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Số lượng'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tên sản phẩm'
                            }
                        }
                    }
                }
            });
        });

        // Dữ liệu cho biểu đồ giá trị
        const productsValueData = <?php echo json_encode($products_value_for_chart); ?>;
        const valueLabels = productsValueData.map(product => product.name);
        const values = productsValueData.map(product => product.quantity * product.price);
        // Biểu đồ giá trị sản phẩm
        $('#productValueChartModal').on('shown.bs.modal', function () {
            const ctx = document.getElementById('productValueChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: valueLabels,
                    datasets: [{
                        label: 'Giá trị sản phẩm (VNĐ)',
                        data: values,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Giá trị (VNĐ)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('vi-VN');
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tên sản phẩm'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let value = context.raw;
                                    return 'Giá trị: ' + value.toLocaleString('vi-VN') + ' VNĐ';
                                }
                            }
                        }
                    }
                }
            });
        });

        // Biểu đồ sản phẩm số lượng thấp
        $('#lowStockProductsModal').on('shown.bs.modal', function () {
            const ctx = document.getElementById('lowStockProductsChart').getContext('2d');
            const lowStockProductsData = <?php echo json_encode($low_stock_products_list); ?>;
            const lowStockLabels = lowStockProductsData.map(product => product.name);
            const lowStockQuantities = lowStockProductsData.map(product => product.remaining_stock);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: lowStockLabels,
                    datasets: [{
                        label: 'Số lượng tồn',
                        data: lowStockQuantities,
                        backgroundColor: 'rgba(255, 159, 64, 0.5)', // Màu cam
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Số lượng tồn'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tên sản phẩm'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let quantity = context.raw;
                                    return 'Số lượng tồn: ' + quantity;
                                }
                            }
                        }
                    }
                }
            });
        });

        // Biểu đồ sản phẩm sắp hết hạn
        $('#expiringProductsModal').on('shown.bs.modal', function () {
            const ctx = document.getElementById('expiringProductsChart').getContext('2d');
            const expiringProductsData = <?php echo json_encode($expiring_products_list); ?>;
            const expiringLabels = expiringProductsData.map(product => product.name);
            const expiringQuantities = expiringProductsData.map(product => product.quantity);
            const expiringDates = expiringProductsData.map(product => product.expiration_date);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: expiringLabels,
                    datasets: [{
                        label: 'Số lượng sản phẩm',
                        data: expiringQuantities,
                        backgroundColor: 'rgba(255, 99, 132, 0.5)', // Màu đỏ nhạt
                        borderColor: 'rgba(255, 99, 132, 1)', // Màu đỏ
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Số lượng'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tên sản phẩm'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += context.raw;
                                    const index = context.dataIndex;
                                    const expirationDate = expiringDates[index];
                                    return label + ' (Hết hạn: ' + expirationDate + ')';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html> 