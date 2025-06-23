<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa danh mục</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #fffbe6;
            font-family: sans-serif;
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
    </style>
</head>
<body>
<div class="wrapper">
    <div class="sidebar">
        <div style="text-align: center;">
            <img src="./uploads/logo.png" alt="EcoMart Logo" style="height: 50px; margin-bottom: 20px;">
        </div>
        <a href="index.php?action=index" ><i class="fas fa-list"></i> Danh sách sản phẩm</a>
        <a href="index.php?action=categories" class="active"><i class="fas fa-cube"></i> Quản lý danh mục</a>
        <a href="index.php?action=reports"><i class="fas fa-chart-bar"></i> Báo cáo & Thống kê</a>
        <a href="index.php?action=logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
    </div>
    <div class="main-content">
        <div class="container mt-5">
            <h2>Sửa danh mục</h2>
            <?php if (!empty($message)) echo $message; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="name">Tên danh mục</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($category['name']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Mô tả</label>
                    <textarea class="form-control" id="description" name="description"><?= htmlspecialchars($category['description']) ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="index.php?action=categories" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>
</body>
</html> 