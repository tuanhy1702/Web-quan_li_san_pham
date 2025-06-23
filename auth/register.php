<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="container" style="max-width:600px;margin-top:50px;margin-bottom:50px;">
    <h3 class="text-center mb-4">Đăng ký tài khoản</h3>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="post" action="../index.php?action=register">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="firstname" class="form-label">Họ</label>
                <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="lastname" class="form-label">Tên</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="birthdate" class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Giới tính</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="male" value="male" required>
                <label class="form-check-label" for="male">Nam</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                <label class="form-check-label" for="female">Nữ</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="other" value="other">
                <label class="form-check-label" for="other">Khác</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">Thành phố</label>
            <select class="form-select" id="city" name="city" required>
                <option value="">Chọn thành phố</option>
                <option value="hanoi">Hà Nội</option>
                <option value="hcm">TP. Hồ Chí Minh</option>
                <option value="danang">Đà Nẵng</option>
                <option value="haiphong">Hải Phòng</option>
                <option value="cantho">Cần Thơ</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Sở thích</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="hobbies[]" value="reading" id="reading">
                <label class="form-check-label" for="reading">Đọc sách</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="hobbies[]" value="music" id="music">
                <label class="form-check-label" for="music">Nghe nhạc</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="hobbies[]" value="movies" id="movies">
                <label class="form-check-label" for="movies">Xem phim</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="hobbies[]" value="football" id="football">
                <label class="form-check-label" for="football">Bóng đá</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="hobbies[]" value="volleyball" id="volleyball">
                <label class="form-check-label" for="volleyball">Bóng chuyền</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="hobbies[]" value="badminton" id="badminton">
                <label class="form-check-label" for="badminton">Cầu lông</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả bản thân</label>
            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Đăng ký</button>
            <a href="login.php" class="btn btn-outline-secondary">Quay lại đăng nhập</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 