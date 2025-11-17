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
   <nav class="navbar navbar-expand-lg navbar-light shadow-sm sticky-top" style="background: linear-gradient(to right, #6EC6FF, #6A1B9A);">

    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php">
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
    <title>QUẢN LÍ THƯ VIỆN</title>
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
    <div class="container">
        <h2 class="text-center mt-3 text-white mb-3" style="background: linear-gradient(to right, #6EC6FF, #6A1B9A);">Quản lí mượn/trả bookHub</h2>
        <ul class="list-group list-group-horizontal mb-4">
            <li class="list-group-item text-center"><a href="../sach/hienthisach.php">Quản lí sách</a></li>
            <li class="list-group-item text-center"><a href="../docgia/hienthidocgia.php">Quản lí độc giả</a></li>
            <li class="list-group-item text-center"><a href="../muontra/hienthimuontra.php">Quản lí mượn trả</a></li>
            <li class="list-group-item text-center"><a href="../tienphat/hienthitienphat.php">Quản lí tiền phạt</a></li>
        </ul>
    </div>

    <div class="container">
        
      <form method="GET" action="timkiemmuontra.php">
    <div class="input-group mb-3" style="width:70%;margin:0 auto;">
        <input type="text" class="form-control" name="timkiem_sach" placeholder="Nhập tên sách để tìm kiếm">
        <input type="text" class="form-control" name="timkiem_docgia" placeholder="Nhập tên độc giả để tìm kiếm">
        <button class="btn btn-primary" name="submit">Tìm kiếm</button>
    </div> 
</form>


        <table class="table table-bordered table-striped text-center">
            <thead>
                <th>STT</th>
                <th>Tên sách</th>
                <th>Tên Độc Giả</th>
                <th>Ngày mượn</th>
                <th>Ngày trả</th>
                <th>Trạng Thái</th>
                <th>Thao tác</th>
            </thead>
            <tbody>
                <?php
                    if(isset($_GET['submit'])){
                        $search = $_GET['timkiem'] ?? '';
                        // Truy vấn theo cấu trúc qlthuvien.sql
                        $sql = "SELECT pm.ma_phieu_muon, s.ten_sach, dg.ten_doc_gia, pm.ngay_muon, pm.ngay_tra, pm.trang_thai
                                FROM phieu_muon pm
                                JOIN doc_gia dg ON pm.ma_doc_gia = dg.ma_doc_gia
                                JOIN chi_tiet_phieu_muon ct ON pm.ma_phieu_muon = ct.ma_phieu_muon
                                JOIN sach s ON ct.ma_sach = s.ma_sach
                                WHERE pm.trang_thai LIKE '%$search%'";
                    }else{
                        $sql = "SELECT pm.ma_phieu_muon, s.ten_sach, dg.ten_doc_gia, pm.ngay_muon, pm.ngay_tra, pm.trang_thai
                                FROM phieu_muon pm
                                JOIN doc_gia dg ON pm.ma_doc_gia = dg.ma_doc_gia
                                JOIN chi_tiet_phieu_muon ct ON pm.ma_phieu_muon = ct.ma_phieu_muon
                                JOIN sach s ON ct.ma_sach = s.ma_sach";
                    }
                    
                    $res = mysqli_query($conn,$sql);
                    $index = 0;
                    if($res){
                        while($rows = mysqli_fetch_assoc($res)){
                            $id = $rows['ma_phieu_muon'];
                            $index++;
                            $tensach = $rows['ten_sach'];
                            $tendg = $rows['ten_doc_gia'];
                            $ngaymuon = $rows['ngay_muon'];
                            $ngaytra = $rows['ngay_tra'];
                            $trangthai = $rows['trang_thai'];
                            ?>
                            <tr>
                                <td><?php echo $index; ?></td>
                                <td><?php echo $tensach; ?></td>
                                <td><?php echo $tendg; ?></td>
                                <td><?php echo $ngaymuon; ?></td>
                                <td><?php echo $ngaytra; ?></td>
                                <td><?php echo $trangthai; ?></td>
                                <td>
                                    <a class="btn btn-warning" href="chinhsuamuontra.php?id=<?php echo $id;?>">sửa</a>
                                    <a class="btn btn-danger" href="xoamuontra.php?id=<?php echo $id; ?>">xóa</a>                            
                                </td>
                            </tr>
                            <?php
                        }
                    }
                ?>
            </tbody>
        </table>

        <a href="themmuontra.php" class="btn btn-success">Thêm Mượn Trả</a>
        
     <!-- Form xuất báo cáo -->
        <form method="GET" action="xuatbaocaomuontra.php" class="mt-3">
                <div class="row">
            <div class="col-sm-3">
            <input type="number" class="form-control" name="thang" placeholder="Tháng" min="1" max="12" required>
            </div>
            <div class="col-sm-3">
            <input type="number" class="form-control" name="nam" placeholder="Năm" min="2000" max="2100" required>
            </div>
            <div class="col-sm-3">
            <button class="btn btn-info" type="submit">Xuất báo cáo</button>
            </div>
        </div>
        </form>


    </div>
</body>
</html>
