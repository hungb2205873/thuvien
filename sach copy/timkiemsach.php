<?php 
    require_once "../config.php";
    if(!isset($_SESSION['tk'])){
        header('location: ../dangnhap.php');
        die();
    }
?>

<!DOCTYPE html>
<html lang="vi">
<!-- head -->
<head>
    <!-- Navigation -->
   <nav class="navbar navbar-expand-lg navbar-light shadow-sm sticky-top" style="background: linear-gradient(to right, #6EC6FF, #6A1B9A);">

    <div class="container-fluid">
     <a class="navbar-brand fw-bold" href="../index.php">
            <span class="text-gradient">📚 BookHub</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <a class="btn btn-primary mt-2" href="../dangxuat.php">Đăng xuất</a>
            </ul>
        </div>
    </div>
</nav>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUẢN LÍ THƯ VIỆN </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<body>
    <div class="container">
        <h2 class="text-center mt-3 text-white mb-3" style="background: linear-gradient(to right, #6EC6FF, #6A1B9A);">Quản lí sách bookHub</h2>

        <ul class="list-group list-group-horizontal mb-4">
            <li class="list-group-item text-center"><a href="../sach/hienthisach.php">Quản lí sách</a></li>
            <li class="list-group-item text-center"><a href="../docgia/hienthidocgia.php">Quản lí độc giả</a></li>
            <li class="list-group-item text-center"><a href="../muontra/hienthimuontra.php">Quản lí mượn trả</a></li>
            <li class="list-group-item text-center"><a href="../tienphat/hienthitienphat.php">Quản lí tiền phạt</a></li>
        </ul>
    </div>

    <div class="container">
        <!-- Form tìm kiếm -->
        <form method="GET" action="timkiemsach.php">
            <div class="input-group mb-3" style="width:50%;margin:0 auto;">
                <input type="text" class="form-control" name="timkiem" placeholder="Nhập tên sách để tìm kiếm">
                <button class="btn btn-primary" name="submit">Tìm kiếm</button>
            </div> 
        </form>

        <!-- Bảng kết quả -->
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên Sách</th>
                    <th>Tác giả</th>
                    <th>NXB</th>
                    <th>Năm XB</th>
                    <th>Số lượng</th>
                    <th>Thể loại</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(isset($_GET['submit'])){
                        $search = $_GET['timkiem'] ?? '';
                        $sql = "SELECT s.ma_sach, s.ten_sach, s.nha_xuat_ban, s.nam_xuat_ban, s.so_luong,
                                       tg.ten_tac_gia, tl.ten_the_loai
                                FROM sach s
                                JOIN tac_gia tg ON s.ma_tac_gia = tg.ma_tac_gia
                                JOIN the_loai tl ON s.ma_the_loai = tl.ma_the_loai
                                WHERE s.ten_sach LIKE '%$search%'";
                    } else {
                        $sql = "SELECT s.ma_sach, s.ten_sach, s.nha_xuat_ban, s.nam_xuat_ban, s.so_luong,
                                       tg.ten_tac_gia, tl.ten_the_loai
                                FROM sach s
                                JOIN tac_gia tg ON s.ma_tac_gia = tg.ma_tac_gia
                                JOIN the_loai tl ON s.ma_the_loai = tl.ma_the_loai";
                    }
                    
                    $res = mysqli_query($conn,$sql);
                    $index = 0;
                    if($res){
                        while($rows = mysqli_fetch_assoc($res)){
                            $index++;
                            $id        = $rows['ma_sach'];
                            $tensach   = $rows['ten_sach'];
                            $tentg     = $rows['ten_tac_gia'];
                            $nhaxuatban= $rows['nha_xuat_ban'];
                            $namxb     = $rows['nam_xuat_ban'];
                            $soluong   = $rows['so_luong'];
                            $theloai   = $rows['ten_the_loai'];
                            ?>
                            <tr>
                                <td><?php echo $index; ?></td>
                                <td><?php echo $tensach; ?></td>
                                <td><?php echo $tentg; ?></td>
                                <td><?php echo $nhaxuatban; ?></td>
                                <td><?php echo $namxb; ?></td>
                                <td><?php echo $soluong; ?></td>
                                <td><?php echo $theloai; ?></td>
                                <td>
                                    <a class="btn btn-warning" href="chinhsuasach.php?id=<?php echo $id;?>">sửa</a>
                                    <a class="btn btn-danger" href="xoasach.php?id=<?php echo $id; ?>">xóa</a>                            
                                </td>
                            </tr>
                            <?php
                        }
                    }
                ?>
            </tbody>
        </table>

        <a href="themsach.php" class="btn btn-success">Thêm Sách</a>
    </div>
</body>
</html>
