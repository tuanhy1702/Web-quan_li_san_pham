<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Danh mục</title>
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
            background-color: #fff;
            border-radius: 16px !important;
            overflow: hidden;
        }
        .table th {
            background-color: #007bff; /* Blue header for table */
            color: white;
        }
        .mb-4 {
            margin-bottom: 10px !important;
        }
        .mb-3 {
            margin-bottom: 10px !important;
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
            <a href="index.php?action=categories" class="active"><i class="fas fa-cube"></i> Quản lý danh mục</a>
            <a href="index.php?action=reports"><i class="fas fa-chart-bar"></i> Báo cáo & Thống kê</a>
            <a href="index.php?action=logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="container-fluid">
                <!-- Header -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <h2></h2>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="index.php?action=create_category" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Thêm danh mục mới
                        </a>
                    </div>
                </div>

                <!-- Categories Table -->
                <?php if(isset($categories) && count($categories) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên danh mục</th>
                                    <th>Mô tả</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($categories as $category): ?>
                                    <tr>
                                        <td><?php echo $category['id']; ?></td>
                                        <td><?php echo htmlspecialchars($category['name']); ?></td>
                                        <td><?php echo htmlspecialchars($category['description'] ?? ''); ?></td>
                                        
                                        <td>
                                            <a href="index.php?action=edit_category&id=<?php echo $category['id']; ?>" 
                                               class="btn btn-info btn-sm mr-1">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <a href="index.php?action=delete_category&id=<?php echo $category['id']; ?>" 
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?');">
                                                <i class="fas fa-trash"></i> Xóa
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">Không có danh mục nào.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html> 