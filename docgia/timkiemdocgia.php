<?php 
    require_once "../config.php";
    if(!isset($_SESSION['tk'])){
        header('location: ../dangnhap.php');
        die();
    }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tìm kiếm độc giả - BookHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
<nav class="navbar navbar-expand-lg navbar-light shadow-sm sticky-top" 
     style="background: linear-gradient(to right, #6EC6FF, #6A1B9A);">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="../index.php">
            <span class="text-gradient">📚  BookHub</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="btn btn-primary mt-2" href="../dangxuat.php">Đăng xuất</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-3">
    <h2 class="text-center mb-3 text-white" 
        style="background: linear-gradient(to right, #6EC6FF, #6A1B9A);">
        Quản lí độc giả - BookHub
    </h2>

    <ul class="list-group list-group-horizontal mb-4">
        <li class="list-group-item text-center">
            <a href="../sach/hienthisach.php">Quản lí sách</a>
        </li>
        <li class="list-group-item text-center">
            <a href="../docgia/hienthidocgia.php">Quản lí độc giả</a>
        </li>
        <li class="list-group-item text-center">
            <a href="../muontra/hienthimuontra.php">Quản lí mượn trả</a>
        </li>
        <li class="list-group-item text-center">
            <a href="../tienphat/hienthitienphat.php">Quản lí tiền phạt</a>
        </li>
    </ul>
     <a class="btn btn-primary mt-2" href="hienthidocgia.php">Quay trở lại</a>
        
</div>


    <div class="container">
        <form method="GET" action="timkiemdocgia.php">
            <div class="input-group mb-3" style="width:50%;margin:0 auto;">
                <input type="text" class="form-control" name="timkiem" placeholder="Nhập tên độc giả để tìm kiếm">
                <button class="btn btn-primary" name="submit">Tìm kiếm</button>
            </div> 
        </form>

        <table class="table table-bordered table-striped text-center">
           
                <tr>
                    <th>STT</th>
                    <th>Tên Độc Giả</th>
                    <th>Ngày Sinh</th>
                    <th>Số Điện Thoại</th>
                    <th>Email</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(isset($_GET['submit'])){
                        $search = $_GET['timkiem'] ?? '';
                        $sql = "SELECT * FROM doc_gia WHERE ten_doc_gia LIKE '%$search%'";
                    }else{
                        $sql = "SELECT * FROM doc_gia";
                    }
                    
                    $res = mysqli_query($conn,$sql);
                    $index = 0;
                    if($res){
                        while($rows = mysqli_fetch_assoc($res)){
                            $id = $rows['ma_doc_gia'];
                            $index++;
                            $tendg = $rows['ten_doc_gia'];
                            $ngaysinh = $rows['ngay_sinh'];
                            $sdt = $rows['so_dien_thoai'];
                            $email = $rows['email'];
                            ?>
                            <tr>
                                <td><?php echo $index; ?></td>
                                <td><?php echo $tendg; ?></td>
                                <td><?php echo $ngaysinh; ?></td>
                                <td><?php echo $sdt; ?></td>
                                <td><?php echo $email; ?></td>
                                <td>
                                    <a class="btn btn-warning btn-sm" href="chinhsuadocgia.php?id=<?php echo $id;?>">Sửa</a>
                                    <a class="btn btn-danger btn-sm" href="xoadocgia.php?id=<?php echo $id; ?>">Xóa</a>                            
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
