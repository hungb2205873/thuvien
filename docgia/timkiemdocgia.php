<?php 
    require_once "../config.php";
    if(!isset($_SESSION['tk'])){
        header('location: ../dangnhap.php');
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<!-- head -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUẢN LÍ SÁCH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- CSS cua tôi -->
    <link rel="stylesheet" href="style.css">
    <style>
        a{
            text-decoration:none;
        }
    </style>

</head>

<!-- body -->
<body>
    <style>
/* Navbar */
.navbar {
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.navbar-brand {
  font-size: 1.5rem;
}

.navbar-brand:hover {
  color: var(--primary) !important;
}

.navbar-nav .nav-link {
  font-weight: 500;
  color: var(--text) !important;
  transition: color 0.3s ease;
}

.navbar-nav .nav-link:hover,
.navbar-nav .nav-link.active {
  color: var(--primary) !important;
}

.dropdown-menu {
  border: 1px solid var(--border);
  border-radius: 8px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.dropdown-item:hover {
  background-color: rgba(102, 126, 234, 0.1);
  color: var(--primary);
}

/* Responsive Navigation */
@media (max-width: 768px) {
  .navbar-brand {
    font-size: 1.25rem;
  }

  .navbar-nav .nav-link {
    padding: 0.5rem 0 !important;
  }
}
</style>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.html">
            <span class="text-gradient">📚 BookHub</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown">
                        Thể Loại
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                        <li><a class="dropdown-item" href="library.html?category=fiction">Tiểu Thuyết</a></li>
                        <li><a class="dropdown-item" href="library.html?category=science">Khoa Học</a></li>
                        <li><a class="dropdown-item" href="library.html?category=history">Lịch Sử</a></li>
                        <li><a class="dropdown-item" href="library.html?category=psychology">Tâm Lý</a></li>
                        <li><a class="dropdown-item" href="library.html?category=business">Kinh Doanh</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="library.html">Thư Viện</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.html">Đăng Nhập</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-gradient btn-sm ms-2" href="signup.html">Đăng Ký</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-gradient btn-sm ms-2" href="dashboard.html">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container">
        <a class="btn btn-primary mt-2" href="hienthidocgia.php">Quay trở lại</a>
        <h2 class="text-center mt-3 bg-success text-white mb-3">quản lí sách bookHub</h2>
        <ul class="list-group list-group-horizontal mb-4">
            <li class="list-group-item list-group-item-action list-group-item-light text-center"><a href="../sach/hienthisach.php">Quản lí sách</a></li>
            <li class="list-group-item list-group-item-action list-group-item-light text-center"><a href="../docgia/hienthidocgia.php">Quản lí độc giả</a></li>
            <li class="list-group-item list-group-item-action list-group-item-light text-center"><a href="../muontra/hienthimuontra.php">Quản lí mượn trả</a></li>
        </ul>
    </div>

    <div class="container">
        
        <form method="GET" action="timkiemdocgia.php">
            <div class="input-group mb-3" style="width:50%;margin:0 auto;">
                <input type="text" class="form-control" name="timkiem" placeholder="Nhập tên độc giả để tìm kiếm">
                <button class="btn btn-primary" name="submit">Tìm kiếm</button>
            </div> 
        </form>

        <table class="table table-bordered table-striped text-center">
            <thead>
                <th>STT</th>
                <th>Tên Độc Giả</th>
                <th>Ngày Sinh</th>
                <th>Địa Chỉ</th>
            </thead>
            <tbody>
                <?php
                    if(isset($_GET['submit'])){
                        if(isset($_GET['timkiem'])){
                            $search = $_GET['timkiem'];
                        }else{
                            $search ='';
                        }
                        $sql = "SELECT * FROM docgia WHERE tendg LIKE '%$search%'";
                    }else{
                        $sql = "CALL hienthidocgia()";
                    }
                    
                    $res = mysqli_query($conn,$sql);//Thực thi câu lệnh sql
                    $index = 0;
                    if($res == true){
                        while($rows = mysqli_fetch_assoc($res)){

                            $id = $rows['id'];

                            $index++;
                            $tendg = $rows['tendg'];
                            $ngaysinh = $rows['ngaysinh'];
                            $diachi = $rows['diachi'];
                            ?>
                            <!-- Viết code của html  -->
                            <tr>
                                <td><?php echo $index; ?></td>

                                <td><?php echo $tendg; ?></td>
                                <td><?php echo $ngaysinh; ?></td>
                                <td><?php echo $diachi; ?></td>
                                <td><a class="btn btn-warning" href="chinhsuadocgia.php?id=<?php echo $id;?>">Edit</a>
                                    <a class="btn btn-danger" href="xoadocgia.php?id=<?php echo $id; ?>">Delete</a>                            
                                </td>
                            </tr>
                            <?php
                        }
                    }
                ?>
                
            </tbody>
        </table>

        <a href="themdocgia.php" class="btn btn-success">Thêm Độc Giả</a>

    </div>
</body>
</html>