# Hệ Thống Quản Lý Sản Phẩm (Product Management System)

Hệ thống quản lý sản phẩm được xây dựng bằng PHP thuần với kiến trúc MVC, hỗ trợ quản lý sản phẩm, danh mục, người dùng và báo cáo thống kê.

## 📋 Mục Lục

- [Giới thiệu](#giới-thiệu)
- [Tính năng](#tính-năng)
- [Công nghệ sử dụng](#công-nghệ-sử-dụng)
- [Cấu trúc dự án](#cấu-trúc-dự-án)
- [Yêu cầu hệ thống](#yêu-cầu-hệ-thống)
- [Hướng dẫn cài đặt](#hướng-dẫn-cài-đặt)
- [Cấu hình](#cấu-hình)
- [Hướng dẫn sử dụng](#hướng-dẫn-sử-dụng)
- [Cấu trúc Database](#cấu-trúc-database)
- [Tác giả](#tác-giả)

## 🎯 Giới thiệu

Đây là hệ thống quản lý sản phẩm hoàn chỉnh với các chức năng CRUD (Create, Read, Update, Delete) cho sản phẩm và danh mục. Hệ thống được thiết kế với kiến trúc MVC (Model-View-Controller) giúp code dễ bảo trì và mở rộng.

Dự án bao gồm:
- **Trang quản trị**: Quản lý sản phẩm, danh mục, xem báo cáo thống kê
- **Trang marketing**: Trang chủ giới thiệu cửa hàng EcoMart (hoa quả sạch)
- **Hệ thống xác thực**: Đăng nhập, đăng ký với phân quyền người dùng

## ✨ Tính năng

### Quản lý Sản phẩm
- ✅ Xem danh sách sản phẩm với phân trang
- ✅ Tìm kiếm sản phẩm theo tên
- ✅ Lọc sản phẩm theo danh mục
- ✅ Sắp xếp sản phẩm (theo tên, số lượng)
- ✅ Thêm sản phẩm mới với upload ảnh
- ✅ Chỉnh sửa thông tin sản phẩm
- ✅ Xóa sản phẩm
- ✅ Quản lý số lượng tồn kho
- ✅ Theo dõi ngày hết hạn sản phẩm

### Quản lý Danh mục
- ✅ Xem danh sách danh mục
- ✅ Thêm danh mục mới
- ✅ Chỉnh sửa danh mục
- ✅ Xóa danh mục

### Hệ thống Người dùng
- ✅ Đăng ký tài khoản mới
- ✅ Đăng nhập/Đăng xuất
- ✅ Phân quyền (Admin/User)
- ✅ Quản lý thông tin cá nhân

### Báo cáo & Thống kê
- ✅ Tổng số sản phẩm
- ✅ Tổng giá trị kho hàng
- ✅ Sản phẩm sắp hết hạn (trong 10 ngày)
- ✅ Sản phẩm tồn kho thấp (< 50)
- ✅ Biểu đồ thống kê số lượng sản phẩm
- ✅ Biểu đồ thống kê giá trị sản phẩm

### Trang Marketing
- ✅ Trang chủ giới thiệu cửa hàng
- ✅ Banner, logo, thông tin liên hệ
- ✅ Giới thiệu về EcoMart

## 🛠 Công nghệ sử dụng

- **Backend**: PHP 7.4+
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework CSS**: Bootstrap 4.5
- **Icons**: Font Awesome 5.15
- **Architecture**: MVC Pattern
- **Database Access**: PDO (PHP Data Objects)

## 📁 Cấu trúc dự án

```
web_quan_li_san_pham/
├── auth/                    # Xác thực người dùng
│   ├── login.php           # Trang đăng nhập
│   └── register.php        # Trang đăng ký
├── config/                  # Cấu hình
│   ├── database.php        # Class kết nối database
│   └── create_users_table.sql
├── controllers/            # Controllers (MVC)
│   ├── ProductController.php
│   ├── CategoryController.php
│   └── ReportController.php
├── models/                  # Models (MVC)
│   ├── Product.php
│   └── Category.php
├── views/                   # Views (MVC)
│   ├── products/
│   │   ├── index.php
│   │   ├── create.php
│   │   └── edit.php
│   ├── categories/
│   │   ├── index.php
│   │   ├── create.php
│   │   └── edit.php
│   └── reports/
│       └── index.php
├── uploads/                 # Thư mục lưu ảnh sản phẩm
├── database/                # File SQL
│   └── product_management.sql
├── index.php                # Front Controller (Routing)
├── index_marketing.php      # Trang marketing
└── intruction.txt          # Hướng dẫn cài đặt
```

## 💻 Yêu cầu hệ thống

- **Web Server**: Apache (XAMPP/WAMP/Laragon)
- **PHP**: 7.4 trở lên
- **MySQL/MariaDB**: 5.7 trở lên
- **Extensions PHP**:
  - PDO
  - PDO_MySQL
  - GD (cho xử lý ảnh)
  - mbstring

## 🚀 Hướng dẫn cài đặt

### Bước 1: Cài đặt môi trường

1. Tải và cài đặt **XAMPP** (hoặc WAMP/Laragon):
   - Download tại: https://www.apachefriends.org/
   - Cài đặt như phần mềm thông thường

2. Khởi động Apache và MySQL từ XAMPP Control Panel

### Bước 2: Clone/Copy dự án

1. Copy toàn bộ thư mục dự án vào thư mục `htdocs` của XAMPP:
   ```
   C:\xampp\htdocs\web_quan_li_san_pham
   ```

### Bước 3: Tạo Database

1. Mở phpMyAdmin: `http://localhost/phpmyadmin`
2. Tạo database mới với tên: `a` (hoặc tên khác tùy bạn)
3. Import file SQL:
   - Chọn database vừa tạo
   - Vào tab **Import**
   - Chọn file `database/product_management.sql`
   - Click **Go** để import

### Bước 4: Cấu hình kết nối Database

Mở file `config/database.php` và kiểm tra/cập nhật thông tin:

```php
private $host = "localhost";
private $db_name = "a";              // Tên database 
private $username = "root";           // Username MySQL
private $password = "";               // Password MySQL (mặc định XAMPP là rỗng)
private $port = "3308";               // Port MySQL (mặc định XAMPP là 3306, kiểm tra lại)
```

**Lưu ý**: 
- Nếu MySQL chạy trên port 3306, đổi `3308` thành `3306`
- Nếu bạn đã đặt password cho MySQL, điền vào trường `$password`

### Bước 5: Phân quyền thư mục uploads

Đảm bảo thư mục `uploads/` có quyền ghi để upload ảnh:
- Windows: Thường không cần cấu hình
- Linux/Mac: Chạy lệnh `chmod 777 uploads/`

### Bước 6: Truy cập ứng dụng

1. **Trang quản trị**: 
   ```
   http://localhost/web_quan_li_san_pham/index.php
   ```

2. **Trang marketing**:
   ```
   http://localhost/web_quan_li_san_pham/index_marketing.php
   ```

## ⚙️ Cấu hình

### Tài khoản mặc định

Sau khi import database, bạn có thể đăng nhập với các tài khoản có sẵn trong database, hoặc đăng ký tài khoản mới.

### Cấu hình phân trang

Trong `controllers/ProductController.php`, bạn có thể thay đổi số sản phẩm hiển thị mỗi trang:

```php
$records_per_page = 6; // Thay đổi số này
```

## 📖 Hướng dẫn sử dụng

### Đăng ký tài khoản

1. Truy cập: `http://localhost/web_quan_li_san_pham/index.php?action=register`
2. Điền đầy đủ thông tin
3. Click "Đăng ký"
4. Sau khi đăng ký thành công, bạn sẽ được chuyển đến trang đăng nhập

### Đăng nhập

1. Truy cập: `http://localhost/web_quan_li_san_pham/index.php?action=login`
   hoặc `http://localhost/web_quan_li_san_pham/auth/login.php`
2. Nhập email và mật khẩu
3. Click "Đăng nhập"

### Quản lý Sản phẩm

- **Xem danh sách**: `index.php?action=index` (mặc định)
- **Thêm sản phẩm**: `index.php?action=create`
- **Sửa sản phẩm**: `index.php?action=edit&id={id_sản_phẩm}`
- **Xóa sản phẩm**: `index.php?action=delete&id={id_sản_phẩm}`

### Quản lý Danh mục

- **Xem danh sách**: `index.php?action=categories`
- **Thêm danh mục**: `index.php?action=create_category`
- **Sửa danh mục**: `index.php?action=edit_category&id={id_danh_mục}`
- **Xóa danh mục**: `index.php?action=delete_category&id={id_danh_mục}`

### Xem Báo cáo

- **Báo cáo thống kê**: `index.php?action=reports`

### Đăng xuất

- Click nút "Đăng xuất" hoặc truy cập: `index.php?action=logout`

## 🗄️ Cấu trúc Database

### Bảng `users`
Quản lý thông tin người dùng
- `id`: ID người dùng (Primary Key)
- `username`: Tên đăng nhập
- `email`: Email (Unique)
- `password`: Mật khẩu (đã mã hóa)
- `fullname`: Họ tên
- `role`: Vai trò (admin/user)
- `birthdate`, `gender`, `city`, `hobbies`, `description`: Thông tin cá nhân

### Bảng `categories`
Quản lý danh mục sản phẩm
- `id`: ID danh mục (Primary Key)
- `name`: Tên danh mục
- `description`: Mô tả
- `created_at`, `updated_at`: Thời gian tạo/cập nhật

### Bảng `products`
Quản lý sản phẩm
- `id`: ID sản phẩm (Primary Key)
- `name`: Tên sản phẩm
- `description`: Mô tả
- `price`: Giá bán
- `purchase`: Giá nhập
- `quantity`: Số lượng tồn kho
- `unit`: Đơn vị tính (KG, Cái, Bộ...)
- `image`: Đường dẫn ảnh
- `category_id`: ID danh mục (Foreign Key)
- `expiration_date`: Ngày hết hạn
- `created_at`, `updated_at`: Thời gian tạo/cập nhật

### Bảng `sold_products`
Lịch sử bán hàng
- `id`: ID bản ghi (Primary Key)
- `product_id`: ID sản phẩm (Foreign Key)
- `quantity`: Số lượng đã bán
- `sale_price`: Giá bán
- `sale_date`: Ngày bán

## 🔒 Bảo mật

- Mật khẩu được mã hóa bằng `password_hash()` với thuật toán bcrypt
- Sử dụng Prepared Statements (PDO) để chống SQL Injection
- Kiểm tra session để bảo vệ các trang cần đăng nhập
- Validate dữ liệu đầu vào

## 📝 Ghi chú

- File `intruction.txt` chứa hướng dẫn cài đặt chi tiết bằng tiếng Việt
- Đảm bảo PHP extension `pdo_mysql` đã được bật
- Kiểm tra quyền ghi của thư mục `uploads/` để upload ảnh thành công

## 👤 Tác giả

Dự án được phát triển cho mục đích học tập và quản lý sản phẩm.

## 📄 License

Dự án này được phát hành dưới dạng mã nguồn mở cho mục đích học tập.

---

**Lưu ý**: Đây là dự án học tập, không nên sử dụng trong môi trường production mà không có các cải tiến về bảo mật và tối ưu hóa.
