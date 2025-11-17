<?php
include('config.php');

$errors = [];

if (isset($_POST['submit'])) {
    $tk = $_POST['tk'] ?? '';
    $mk = $_POST['mk'] ?? '';

    $tk = mysqli_real_escape_string($conn, $tk);
    $mk = mysqli_real_escape_string($conn, $mk);

    if ($tk == '') {
        $errors['tk'] = "Bạn chưa nhập tài khoản";
    }
    if ($mk == '') {
        $errors['mk'] = "Bạn chưa nhập mật khẩu";
    }

    if (!$errors) {
        $sql = "SELECT * FROM admin WHERE tk='$tk' AND mk='$mk'";
        $res = mysqli_query($conn, $sql);

        if ($res && mysqli_num_rows($res) > 0) {
            $_SESSION['tk'] = $tk;
            header("Location: sach/hienthisach.php");
            exit;
        } else {
            $_SESSION['dangnhap'] = "Tài khoản hoặc mật khẩu không hợp lệ!";
        }
    } else {
        $_SESSION['dangnhap'] = "Đăng nhập thất bại!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập - 📚 BookHub</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="header.css">

</head>
<body>
<header class="header">
     <nav class="navbar">
      <div class="container">
        <div class="nav-wrapper">
          <div class="logo">
            <a href="<?php echo $links['home']; ?>">📚 BookHub</a>
          </div>
          <button class="menu-toggle" id="menuToggle">
            <span></span>
            <span></span>
            <span></span>
          </button>
          <ul class="nav-menu" id="navMenu">
            <li> <a href="index.php">Trang chủ</a> </li>
             <li><a href="">Thư Viện</a></li>
            <li class="nav-dropdown">
              <a href="#" class="dropdown-toggle">Thể Loại</a>
            </li>

          </ul>
        </div>
      </div>
    </nav>
        <!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-success shadow-sm sticky-top">
    <div class="container-fluid">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                
            </ul>
        </div>
    </div>
</nav>
</header>

<div class="login-wrapper">
    <div class="login-left">
         
            <div class="login-left-content">
                <h2>📚 Chào Mừng Đến BookHub</h2>
                <p>Khám phá thế giới sách vô tận và quản lý thư viện của bạn một cách dễ dàng.</p>
                
                <div class="login-features">
                    <div class="login-features-item">
                        <div class="login-features-icon">📖</div>
                        <div class="login-features-text">
                            <h4>Kho Sách Khổng Lồ</h4>
                            <p>Truy cập hàng triệu đầu sách từ khắp nơi trên thế giới</p>
                        </div>
                    </div>

                    <div class="login-features-item">
                        <div class="login-features-icon">⭐</div>
                        <div class="login-features-text">
                            <h4>Gợi Ý Cá Nhân</h4>
                            <p>Nhận gợi ý sách phù hợp với sở thích của bạn</p>
                        </div>
                    </div>

                    <div class="login-features-item">
                        <div class="login-features-icon">📊</div>
                        <div class="login-features-text">
                            <h4>Quản Lý Đơn Giản</h4>
                            <p>Theo dõi sách mượn, lịch sử đọc một cách tiện lợi</p>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <div class="login-right">
        <div class="login-form-container">
            <div class="login-form-header">
                <h1>Đăng Nhập</h1>
                <p>Truy cập tài khoản BookHub của bạn</p>
            </div>

            <!-- Thông báo từ PHP -->
            <?php 
                if(isset($_SESSION['dangnhap'])){
                    echo "<div class='login-error'>".$_SESSION['dangnhap']."</div>";
                    unset($_SESSION['dangnhap']);
                }
            ?>

            <form method="POST" action="">
                <div class="login-form-group">
                    <label for="tk">Tài Khoản</label>
                    <input type="text" id="tk" name="tk" placeholder="Nhập tài khoản">
                    <?php if(isset($errors['tk'])) echo "<div class='login-error'>".$errors['tk']."</div>"; ?>
                </div>

                <div class="login-form-group">
                    <label for="mk">Mật Khẩu</label>
                    <input type="password" id="mk" name="mk" placeholder="Nhập mật khẩu">
                    <?php if(isset($errors['mk'])) echo "<div class='login-error'>".$errors['mk']."</div>"; ?>
                </div>

                <button type="submit" name="submit" class="login-btn">Đăng Nhập</button>
            </form>

            <div class="login-divider"><span>Hoặc</span></div>
            <div class="login-signup-text">
                Chưa có tài khoản? <a href="signup.html">Đăng Ký Ngay</a>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
 
</footer>
 <script src="script.js"></script>
</body>
</html>
