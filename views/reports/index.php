<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Báo cáo & Thống kê</title>
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
            min-width: 200px;
            max-width: 220px;
            background-color: #004085;
            color: #ffffff;
            height: 100vh;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
        }
        .sidebar a {
            color: #cce5ff;
            padding: 12px 15px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s ease;
        }
        .sidebar a:hover {
            background-color: #0056b3;
            color: #ffffff;
        }
        .sidebar .active {
            background-color: #007bff;
            color: #ffffff;
        }
        .sidebar h4 {
            color: #ffffff;
            margin-bottom: 30px;
        }
        .main-content {
            flex-grow: 1;
            padding: 10px;
            margin-left: 220px;
        }
        #productRevenuePieChart {
            max-width: 300px;
            max-height: 300px;
            margin: 0 auto;
            display: block;
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
        <a href="index.php?action=index"><i class="fas fa-list"></i> Danh sách sản phẩm</a>
        <a href="index.php?action=categories"><i class="fas fa-cube"></i> Quản lý danh mục</a>
        <a href="index.php?action=reports" class="active"><i class="fas fa-chart-bar"></i> Báo cáo & Thống kê</a>
        <a href="index.php?action=logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
    </div>
    <!-- Main Content -->
    <div class="main-content">
        <div class="container mt-5">

            <div class="row d-flex align-items-stretch">
                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header" style="font-size: 24px;">Tổng sản phẩm bán được</div>
                        <div class="card-body">
                            <h5 class="card-title" style="font-size: 30px;"><?php echo number_format($total_sold); ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-header" style="font-size: 24px;">Tổng doanh thu</div>
                        <div class="card-body">
                            <h5 class="card-title" style="font-size: 30px;"><?php echo number_format($total_revenue, 0, ',', '.'); ?> VNĐ</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-header" style="font-size: 24px;">Sản phẩm bán chạy nhất</div>
                        <div class="card-body">
                            <h5 class="card-title" style="font-size: 30px;"><?php echo $best_seller ? htmlspecialchars($best_seller['name']) : 'Chưa có dữ liệu'; ?></h5>
                            <p class="card-text">Số lượng: <?php echo $best_seller ? $best_seller['sold_qty'] : 0; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bộ lọc biểu đồ -->
            <div class="mb-3">
                <form method="GET" action="index.php" class="form-inline">
                    <input type="hidden" name="action" value="reports">
                    <label for="group_by" class="mr-2">Xem theo:</label>
                    <select name="group_by" id="group_by" onchange="this.form.submit()" class="form-control mr-4">
                        <option value="day" <?= (!isset($_GET['group_by']) || $_GET['group_by']=='day') ? 'selected' : '' ?>>Ngày</option>
                        <option value="week" <?= (isset($_GET['group_by']) && $_GET['group_by']=='week') ? 'selected' : '' ?>>Tuần</option>
                        <option value="month" <?= (isset($_GET['group_by']) && $_GET['group_by']=='month') ? 'selected' : '' ?>>Tháng</option>
                        <option value="year" <?= (isset($_GET['group_by']) && $_GET['group_by']=='year') ? 'selected' : '' ?>>Năm</option>
                    </select>

                    <label for="category_filter" class="mr-2">Lọc theo danh mục:</label>
                    <select name="category_filter" id="category_filter" onchange="this.form.submit()" class="form-control">
                        <option value="">Tất cả danh mục</option>
                        <?php foreach ($all_categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?php if(isset($_GET['category_filter']) && $_GET['category_filter'] == $cat['id']) echo 'selected'; ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
            <!-- Biểu đồ -->
            <div class="card mt-4" >
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-chart-line"></i> Biểu đồ số lượng sản phẩm bán ra
                </div>
                <div class="card-body">
                    <canvas id="soldLineChart"></canvas>
                </div>
            </div>
            <div class="card mt-4" style="max-width: 350px; margin-left: 0; display:none;" >
                <div class="card-header bg-info text-white">
                    <i class="fas fa-chart-pie"></i> Doanh thu toàn bộ
                </div>
                <div class="card-body" style="max-width: 350px; margin-left: 0;">
                    <canvas id="productRevenuePieChart" width="300" height="300" style="max-width:300px;max-height:300px;"></canvas>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-chart-bar"></i> Biểu đồ doanh thu
                </div>
                <div class="card-body">
                    <canvas id="revenueBarChart"></canvas>
                </div>
            </div>
            <h4 class="mt-4 mb-2">Bảng hàng tồn kho</h4>
            <table class="table table-bordered table-striped" style="background: #fff;">
                <thead>
                    <tr style="background: #ffe066;" >
                        <th>Mã SP</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng nhập</th>
                        <th>Số lượng đã bán</th>
                        <th>Số lượng tồn kho</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventory as $row): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= $row['so_luong_nhap'] ?></td>
                        <td><?= $row['so_luong_ban'] ?></td>
                        <td><?= $row['ton_kho'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <nav>
              <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                  <?php
                    $get_params = $_GET;
                    $get_params['action'] = 'reports';
                    $get_params['inv_page'] = $i;
                    $link = '?' . http_build_query($get_params);
                  ?>
                  <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link inventory-pagination" href="<?= $link ?>"><?= $i ?></a>
                  </li>
                <?php endfor; ?>
              </ul>
            </nav>
            

            

            
            
            
            
           

            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Nhúng plugin Zoom -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@2.0.1/dist/chartjs-plugin-zoom.min.js"></script>
<script>
const saleLabels = <?php echo json_encode($labels); ?>;
const chartDatasets = <?php echo json_encode($chart_datasets); ?>;

// Danh sách các màu sắc đa dạng
const predefinedColors = [

    
  '#FF6666', // Light Red
  '#6699FF', // Light Blue
  '#FFB84D', // Light Orange
  '#66B2AA', // Light Teal
  '#AA80CC', // Light Purple
  '#FFB266', // Light Orange
  '#4DB68D', // Soft Sea Green
  '#FF99CC', // Light Pink
  '#7BA6D9', // Soft Steel Blue
  '#FFE066', // Soft Gold
  '#66D9CC', // Light Turquoise
  '#FF7F4D', // Soft Orange Red
  '#8F9DE5', // Light Slate Blue
  '#7CD66B', // Light Lime Green
  '#FF66B2', // Soft Deep Pink
  '#4DA6FF', // Soft Dodger Blue
  '#E6C258', // Soft Goldenrod
  '#B24D4D', // Soft Dark Red
  '#4DD1D1', // Soft Dark Turquoise
  '#CFFF80', // Light Green Yellow
  '#FF8C73', // Soft Tomato
  '#6B3D99', // Soft Indigo
  '#B2FF4D', // Light Chartreuse
  '#FF9980', // Soft Coral
  '#4DB0A6', // Soft Light Sea Green
  '#B499E0', // Light Medium Purple
  '#56B87D', // Light Medium Sea Green
  '#FF66FF', // Soft Magenta
  '#99D6CC', // Light Medium Aquamarine
  '#CC5555'  // Soft Firebrick




];

chartDatasets.forEach((ds, index) => {
    // Lấy màu từ danh sách theo index, lặp lại nếu vượt quá số màu
    const color = predefinedColors[index % predefinedColors.length];
    ds.borderColor = color;
    ds.backgroundColor = 'rgba(0,0,0,0)'; // Giữ trong suốt
    ds.tension = 0.3;
    ds.pointRadius = 4;
    ds.pointHoverRadius = 7;
    ds.fill = false;
});

const ctx = document.getElementById('soldLineChart').getContext('2d');

// Gán biểu đồ vào biến myChart để có thể gọi resetZoom() và pan
const myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: saleLabels,
        datasets: chartDatasets
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true },
            // Cấu hình Zoom và Pan
            zoom: {
                zoom: {
                    wheel: {
                        enabled: true, // Bật zoom bằng con lăn chuột
                    },
                    pinch: {
                        enabled: true // Bật zoom bằng cử chỉ chụm (trên thiết bị cảm ứng)
                    },
                    mode: 'x', // Chỉ zoom theo trục ngang (thời gian)
                },
                // Cấu hình Pan (Kéo)
                pan: {
                    enabled: true, // Bật tính năng kéo biểu đồ
                    mode: 'x', // Chỉ kéo theo trục ngang
                    threshold: 5 // Số pixel cần kéo để bắt đầu pan (có thể điều chỉnh)
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: { display: true, text: 'Số lượng bán' }
            },
            x: {
                title: { display: true, text: 'Thời gian' }
            }
        }
    }
});

// Xử lý nút Reset Zoom (đảm bảo myChart đã được gán)


const productRevenuePieCtx = document.getElementById('productRevenuePieChart').getContext('2d');
const productRevenuePieChart = new Chart(productRevenuePieCtx, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($product_revenue_chart['labels'] ?? []); ?>,
        datasets: [{
            label: 'Doanh thu',
            data: <?php echo json_encode($product_revenue_chart['revenue'] ?? []); ?>,
            backgroundColor: [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#C9CBCF', '#FF6384', '#36A2EB', '#FFCE56'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Tỷ lệ doanh thu theo sản phẩm (bán ra)'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let label = context.label || '';
                        let value = context.raw || 0;
                        return label + ': ' + value.toLocaleString('vi-VN') + ' VNĐ';
                    }
                }
            }
        }
    }
});

// Biểu đồ doanh thu theo bộ lọc group_by và category_filter
const revenueLabels = <?php echo json_encode($revenue_labels ?? []); ?>;
const revenueData = <?php echo json_encode($revenue_data ?? []); ?>;
const revenueBarCtx = document.getElementById('revenueBarChart').getContext('2d');
const revenueBarChart = new Chart(revenueBarCtx, {
    type: 'bar',
    data: {
        labels: revenueLabels,
        datasets: [{
            label: 'Doanh thu',
            data: revenueData,
            backgroundColor: '#36A2EB',
            borderColor: '#007bff',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            title: {
                display: true,
                text: 'Doanh thu theo ' + (
                    <?php echo json_encode($_GET['group_by'] ?? 'day'); ?> === 'day' ? 'ngày' :
                    (<?php echo json_encode($_GET['group_by'] ?? 'day'); ?> === 'week' ? 'tuần' :
                    (<?php echo json_encode($_GET['group_by'] ?? 'day'); ?> === 'month' ? 'tháng' : 'năm'))
                )
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let value = context.raw || 0;
                        return value.toLocaleString('vi-VN') + ' VNĐ';
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: { display: true, text: 'Doanh thu (VNĐ)' }
            },
            x: {
                title: { display: true, text: 'Thời gian' }
            }
        }
    }
});

// Lưu vị trí cuộn trước khi chuyển trang
document.querySelectorAll('.inventory-pagination').forEach(function(link) {
    link.addEventListener('click', function(e) {
        // Lưu vị trí cuộn vào localStorage
        localStorage.setItem('inventoryScroll', window.scrollY);
    });
});

// Khi trang load lại, cuộn về vị trí cũ nếu có
window.addEventListener('DOMContentLoaded', function() {
    const scroll = localStorage.getItem('inventoryScroll');
    if (scroll !== null) {
        window.scrollTo(0, parseInt(scroll));
        localStorage.removeItem('inventoryScroll');
    }
});

</script>
</body>
</html> 