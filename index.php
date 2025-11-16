<?php include_once 'config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BookHub - Khám Phá Thế Giới Sách</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f5f5;
    }

    /* HEADER */
    header {
      background: linear-gradient(135deg, #6c7dd6 0%, #704b9e 100%);
      padding: 15px 0;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .header-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 20px;
    }

    .logo {
      display: flex;
      align-items: center;
      font-size: 24px;
      font-weight: bold;
      color: white;
      gap: 8px;
    }

    .logo-icon {
      font-size: 28px;
    }

    .nav-menu {
      display: flex;
      list-style: none;
      gap: 30px;
      align-items: center;
    }

    .nav-menu a {
      color: white;
      text-decoration: none;
      font-size: 16px;
      transition: opacity 0.3s;
    }

    .nav-menu a:hover {
      opacity: 0.8;
    }

    .btn-signup {
      background: transparent;
      border: 2px solid white;
      color: white;
      padding: 8px 20px;
      border-radius: 20px;
      cursor: pointer;
      font-size: 16px;
      transition: all 0.3s;
    }

    .btn-signup:hover {
      background: white;
      color: #704b9e;
    }

    /* HERO SECTION */
    .hero {
      background-color: #f0f0f5;
      padding: 80px 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 600px;
    }

    .hero-container {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 50px;
      align-items: center;
    }

    .hero-content h1 {
      font-size: 48px;
      font-weight: bold;
      color: #1a1a3e;
      line-height: 1.3;
      margin-bottom: 20px;
    }

    .hero-content p {
      font-size: 16px;
      color: #666;
      margin-bottom: 30px;
      line-height: 1.6;
    }

    .search-box {
      display: flex;
      gap: 10px;
      margin-bottom: 30px;
    }

    .search-input {
      flex: 1;
      padding: 12px 20px;
      border: none;
      border-radius: 25px;
      font-size: 14px;
      background: white;
      max-width: 300px;
    }

    .search-input::placeholder {
      color: #999;
    }

    .search-btn {
      background: linear-gradient(135deg, #6c7dd6 0%, #704b9e 100%);
      color: white;
      border: none;
      padding: 12px 25px;
      border-radius: 25px;
      cursor: pointer;
      font-size: 14px;
      font-weight: 600;
      transition: transform 0.3s;
    }

    .search-btn:hover {
      transform: scale(1.05);
    }

    .button-group {
      display: flex;
      gap: 15px;
    }

    .btn-primary {
      background: linear-gradient(135deg, #6c7dd6 0%, #704b9e 100%);
      color: white;
      border: none;
      padding: 12px 30px;
      border-radius: 25px;
      cursor: pointer;
      font-size: 16px;
      font-weight: 600;
      transition: transform 0.3s;
    }

    .btn-primary:hover {
      transform: scale(1.05);
    }

    .btn-secondary {
      background: white;
      color: #6c7dd6;
      border: 2px solid #6c7dd6;
      padding: 10px 28px;
      border-radius: 25px;
      cursor: pointer;
      font-size: 16px;
      font-weight: 600;
      transition: all 0.3s;
    }

    .btn-secondary:hover {
      background: #6c7dd6;
      color: white;
    }

    /* BOOK ICONS */
    .book-icons {
      display: flex;
      justify-content: flex-end;
      gap: 20px;
      align-items: center;
    }

    .book-icon {
      width: 80px;
      height: 120px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 40px;
      color: white;
      font-weight: bold;
    }

    .book-icon.dark {
      background: #2c3e50;
    }

    .book-icon.blue {
      background: #3498db;
    }

    .book-icon.red {
      background: #e74c3c;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .hero-container {
        grid-template-columns: 1fr;
      }

      .hero-content h1 {
        font-size: 32px;
      }

      .nav-menu {
        gap: 15px;
      }

      .book-icons {
        justify-content: center;
      }

      .search-box {
        flex-direction: column;
      }

      .search-input {
        max-width: 100%;
      }

      .button-group {
        flex-direction: column;
      }

      .btn-primary,
      .btn-secondary {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <!-- HEADER -->
  <header>
    <div class="header-container">
      <div class="logo">
        <span class="logo-icon">📚</span>
        <span>BookHub</span>
      </div>
      <nav>
        <ul class="nav-menu">
          <li><a href="index.php">Trang Chủ</a></li>
          <li><a href="#categories">Thể Loại</a></li>
          <li><a href="#books">Thư Viện</a></li>
           <li><a href="dangnhap.php">Đăng nhập</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- HERO SECTION -->
  <section class="hero">
    <div class="hero-container">
      <div class="hero-content">
        <h1>Khám Phá Thế Giới Sách Vô Tận</h1>
        <p>Truy cập bộ sưu tập hàng ngàn cuốn sách được tuyển chọn dành cho bạn</p>

        <div class="search-box">
          <input type="text" class="search-input" placeholder="Tìm kiếm sách, tác giả...">
          <button class="search-btn">🔍 Tìm Kiếm</button>
        </div>

        <div class="button-group">
            <button class="btn-primary" onclick="window.location.href='<?php echo $links['signup']; ?>';">Đăng Ký Miễn Phí</button>
            <button class="btn-secondary" onclick="window.location.href='dangnhap.php';">Đăng Nhập</button>
     </div>
      </div>

      <!-- BOOK ICONS -->
      <div class="book-icons">
        <div class="book-icon dark">●</div>
        <div class="book-icon blue">●</div>
        <div class="book-icon red">●</div>
      </div>
    </div>
  </section>
</body>
</html>
