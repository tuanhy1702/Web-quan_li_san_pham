<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoMart  - Trang chủ</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }
        .top-bar {
            background-color: rgb(27, 145, 31); /* Màu xanh lá cây */
            color: white;
            padding: 5px 0;
            font-size: 0.9em;
        }
        .top-bar a {
            color: white;
            text-decoration: none;
        }
        .header-main {
            background-color: white;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .navbar-main {
            background-color: #f0f0f0; /* Màu xám nhạt */
            padding: 8px 0;
        }
        .navbar-main a {
            color: #333;
            text-decoration: none;
            padding: 0 15px;
            font-weight: bold;
        }
         .navbar-main a:hover {
            color:rgb(27, 145, 31); /* Màu xanh lá cây khi hover */
        }
        .hero-section {
            background-image: url('./uploads/banner.png'); /* Thay bằng đường dẫn ảnh banner của bạn */
            background-size: cover;
            background-position: center;
            height: 450px; /* Điều chỉnh chiều cao theo nhu cầu */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-top: 10px;
        }
        /* Thêm CSS cho các phần khác nếu cần */
    </style>
</head>
<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-left">
                    <i class="fas fa-phone-alt"></i> EcoMart: 1900 2268
                </div>
                <div class="col-md-6 text-right">
                    <i class="fas fa-shopping-cart"></i> Giỏ hàng trống
                    <a href="./auth/login.php" style="margin-left: 15px;"><i class="fas fa-sign-out-alt"></i> Đăng nhập</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Main -->
    <div class="header-main">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <!-- Logo -->
                    <img src="./uploads/logo.png" alt="EcoMart Logo" style="height: 50px;"> <!-- Thay bằng đường dẫn ảnh logo của bạn -->
                </div>
                <div class="col-md-6">
                    <!-- Search Bar -->
                    <form class="form-inline justify-content-center">
                        <input class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm" aria-label="Search" style="width: 70%;">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="col-md-3 text-right">
                    <!-- Store System Button -->
                    <button class="btn btn-success"><i class="fas fa-map-marker-alt"></i> Hệ thống cửa hàng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="navbar-main">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <a href="#">Home</a>
                    <a href="#">Sản Phẩm</a>
                    <a href="#">Thanh toán</a>
                    <a href="#">Tin tức</a>
                    <a href="#">Giới thiệu</a>
                    <a href="#">Mùa vụ hoa quả</a>
                    <a href="#">Hệ thống cửa hàng</a>
                    <a href="#">Liên hệ</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section (Banner) -->
    <div class="hero-section">
        <!-- Nội dung banner (text, nút,...) có thể thêm vào đây -->
    </div>

    <!-- Section: 3 Lý Do -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">3 LÝ DO MUA HOA QUẢ TẠI EcoMart</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="icon mb-3">
                        <img src="./uploads/t1_3.png" alt="Icon Hoa quả tươi sạch" style="width: 50px; height: 50px;"/>
                    </div>
                    <h4>HOA QUẢ TƯƠI SẠCH</h4>
                    <p>Quy trình nhập hàng, vận chuyển, bảo quản chuyên nghiệp.</p>
                </div>
                <div class="col-md-4">
                    <div class="icon mb-3">
                         <img src="./uploads/t1_4.png" alt="Icon Đổi trả miễn phí" style="width: 50px; height: 50px;"/>
                    </div>
                    <h4>ĐỔI TRẢ MIỄN PHÍ</h4>
                    <p>Đổi trả miễn phí trong 24h khi khách hàng không hài lòng</p>
                </div>
                <div class="col-md-4">
                     <div class="icon mb-3">
                         <img src="./uploads/t1_5.png" alt="Icon Giá cả cạnh tranh" style="width: 50px; height: 50px;"/>
                    </div>
                    <h4>GIÁ CẢ CẠNH TRANH</h4>
                    <p>EcoMart luôn đặt lợi ích cho người tiêu dùng lên hàng đầu.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Đôi Nét Về EcoMart & Giới thiệu chung -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <!-- Đôi Nét Về EcoMart -->
                <div class="col-md-6">
                    <h3><i class="fas fa-leaf" style="color: #4CAF50;"></i> ĐÔI NÉT VỀ EcoMart</h3>
                    <p>
                        Với tôn chỉ "Mang đến cho khách hàng không chỉ là những sản phẩm trái cây an toàn, chất lượng cao, mà kèm theo đó là những dịch vụ tiện ích thân thiện. "Công ty CP xuất nhập khẩu EcoMart" - đơn vị chuyên nhập khẩu các loại trái cây cao cấp từ các nước trên thế giới đang từng bước phát triển và chiếm được lòng tin của người tiêu dùng Việt Nam. Hiện tại, công ty có hệ thống các cửa hàng mang thương hiệu Hoa quả sạch EcoMart được phân bố rộng khắp trên địa bàn các tỉnh phía Bắc phục vụ đủ nhu cầu cho mọi khách hàng. Bằng những nỗ lực không ngừng theo thời gian, hệ thống Hoa quả sạch EcoMart từng ngày hoàn thiện hơn về tất cả mọi mặt.
                    </p>
                    <p class="text-right"><a href="#" class="text-success">→ Giới thiệu chung</a></p>
                </div>

                <!-- Giới thiệu chung -->
                <div class="col-md-6">
                    <h3><i class="fas fa-book-open" style="color: #4CAF50;"></i> Giới thiệu chung</h3>
                    <div class="media mb-3">
                        <div class="media-body">
                            <h5 class="mt-0">Văn hóa EcoMart</h5>
                            Với thông điệp "Yêu thương cho đi là yêu thương còn mãi", hoa quả sạch EcoMart và
                        </div>
                    </div>
                     <div class="media mb-3">
                        <div class="media-body">
                            <h5 class="mt-0">Hoa quả của EcoMart</h5>
                            Mang tôn chỉ "An toàn cho sức khỏe gia đình bạn!" – Hoa quả sạch EcoMart luôn
                        </div>
                    </div>
                     <div class="media mb-3">
                        <div class="media-body">
                            <h5 class="mt-0">Quy trình sản phẩm h...</h5>
                            Hàng tháng, hệ thống Hoa quả sạch EcoMart cung cấp hơn 41 tấn hoa quả sạch nhập
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Các phần khác của trang chủ sẽ ở dưới đây -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<!-- Footer -->
<footer style="background-color: rgb(27, 145, 31); color: white; padding: 40px 0; font-size: 0.9em;">
<div class="container">
<div class="row">
<div class="col-md-4">
<h5>CHÍNH SÁCH</h5>
<ul style="list-style: none; padding: 0;">
<li><a href="#" style="color: white;">Chính sách bảo mật thông tin</a></li>
<li><a href="#" style="color: white;">Quy định và hình thức thanh toán</a></li>
<li><a href="#" style="color: white;">Chính sách thành viên EcoMart</a></li>
<li><a href="#" style="color: white;">Chính sách đổi trả</a></li>
<li><a href="#" style="color: white;">Chính sách vận chuyển</a></li>
<li><a href="#" style="color: white;">Câu hỏi thường gặp</a></li>
<li><a href="#" style="color: white;">Liên hệ</a></li>
</ul>
</div>
<div class="col-md-4">
<h5>HỖ TRỢ MUA HÀNG</h5>
<ul style="list-style: none; padding: 0;">
<li><a href="#" style="color: white;">Hệ thống cửa hàng</a></li>
<li><a href="#" style="color: white;">Hướng dẫn mua hàng</a></li>
<li><a href="#" style="color: white;">Hóa đơn VAT</a></li>
</ul>
<!-- Badge placeholder, replace with actual image if available -->
<img src="./uploads/badge_bo_cong_thuong.png" alt="Đã thông báo Bộ Công Thương" style="margin-top: 15px; height: 50px;">
</div>
<div class="col-md-4">
<h5>CÔNG TY CP XUẤT NHẬP KHẨU EcoMart</h5>
<p>Trụ sở: 352 Giải Phóng, Phương Liệt, Thanh Xuân, Hà Nội</p>
<p>Hotline: 1900 2268 - 0899 96 69 96</p>
<p>Website: <a href="http://www.hoaquaEcoMart.com" style="color: white;">www.hoaquaEcoMart.com</a></p>
<p>Giấy CNĐKKD: 0107875928 do Sở Kế hoạch và Đầu tư TP Hà Nội cấp ngày 09/06/2017</p>
</div>
</div>
<hr style="border-color: rgba(255, 255, 255, 0.3);">
<div class="row align-items-center">
<div class="col-md-6">
<p style="margin-bottom: 0;">© 2018 Hệ thống hoa quả sạch EcoMart Fruit</p>
</div>
<div class="col-md-6 text-right">
<a href="#" style="color: white; margin: 0 5px;"><i class="fab fa-facebook-f"></i></a>
<a href="#" style="color: white; margin: 0 5px;"><i class="fab fa-google-plus-g"></i></a>
<a href="#" style="color: white; margin: 0 5px;"><i class="fab fa-twitter"></i></a>
<a href="#" style="color: white; margin: 0 5px;"><i class="fab fa-youtube"></i></a>
</div>
</div>
</div>
</footer>
</html> 