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
    <title>Quản Lí Tiền Phạt - 📚 BookHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        a { text-decoration:none; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm sticky-top" style="background: linear-gradient(to right, #6EC6FF, #6A1B9A);">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="../index.php">
                <span class="text-gradient">📚 BookHub</span>
            </a>
            <ul class="navbar-nav ms-auto">
                <a class="btn btn-primary mt-2" href="../dangxuat.php">Đăng xuất</a>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center mb-3 text-white" style="background: linear-gradient(to right, #6EC6FF, #6A1B9A);">Quản lí tiền phạt BookHub</h2>
        <ul class="list-group list-group-horizontal mb-4">
            <li class="list-group-item text-center"><a href="../sach/hienthisach.php">Quản lí sách</a></li>
            <li class="list-group-item text-center"><a href="../docgia/hienthidocgia.php">Quản lí độc giả</a></li>
            <li class="list-group-item text-center"><a href="../muontra/hienthimuontra.php">Quản lí mượn trả</a></li>
            <li class="list-group-item text-center"><a href="hienthitienphat.php">Quản lí tiền phạt</a></li>
        </ul>

        <!-- Thanh tìm kiếm theo tên độc giả -->
        <form method="GET" action="hienthitienphat.php">
            <div class="input-group mb-3" style="width:50%;margin:0 auto;">
                <input type="text" class="form-control" name="timkiem" placeholder="Tìm kiếm theo tên độc giả" value="<?php echo $_GET['timkiem'] ?? ''; ?>">
                <button class="btn btn-primary" name="submit">Tìm kiếm</button>
            </div> 
        </form>

        <table class="table table-bordered table-striped text-center">
            <tr>
                <th>STT</th>
                <th>Tên Độc Giả</th>
                <th>Tên Sách</th>
                <th>Ngày Mượn</th>
                <th>Ngày Trả</th>
                <th>Tình Trạng</th>
                <th>Tiền Phạt</th>
            </tr>
            <tbody>
                <?php
                    if(isset($_GET['submit'])){
                        $search = $_GET['timkiem'] ?? '';
                        $sql = "SELECT dg.ten_doc_gia, s.ten_sach, pm.ngay_muon, pm.ngay_tra, pm.trang_thai
                                FROM phieu_muon pm
                                JOIN doc_gia dg ON pm.ma_doc_gia = dg.ma_doc_gia
                                JOIN chi_tiet_phieu_muon ct ON pm.ma_phieu_muon = ct.ma_phieu_muon
                                JOIN sach s ON ct.ma_sach = s.ma_sach
                                WHERE pm.trang_thai = 'Trả muộn'
                                  AND dg.ten_doc_gia LIKE '%$search%'
                                ORDER BY pm.ngay_tra ASC";
                    } else {
                        $sql = "SELECT dg.ten_doc_gia, s.ten_sach, pm.ngay_muon, pm.ngay_tra, pm.trang_thai
                                FROM phieu_muon pm
                                JOIN doc_gia dg ON pm.ma_doc_gia = dg.ma_doc_gia
                                JOIN chi_tiet_phieu_muon ct ON pm.ma_phieu_muon = ct.ma_phieu_muon
                                JOIN sach s ON ct.ma_sach = s.ma_sach
                                WHERE pm.trang_thai = 'Trả muộn'
                                ORDER BY pm.ngay_tra ASC";
                    }

                    $res = mysqli_query($conn, $sql);
                    $index = 0;
                    $tongTheoDocGia = []; // mảng lưu tổng tiền phạt theo từng độc giả
                    if($res){
                        while($rows = mysqli_fetch_assoc($res)){
                            $index++;
                            $tendg = $rows['ten_doc_gia'];
                            $tensach = $rows['ten_sach'];
                            $ngaymuon = $rows['ngay_muon'];
                            $ngaytra = $rows['ngay_tra'];
                            $trangthai = $rows['trang_thai'];
                            $tienphat = 10000; // mặc định 10,000đ

                            if(!isset($tongTheoDocGia[$tendg])){
                                $tongTheoDocGia[$tendg] = 0;
                            }
                            $tongTheoDocGia[$tendg] += $tienphat;
                            ?>
                            <tr>
                                <td><?php echo $index; ?></td>
                                <td><?php echo $tendg; ?></td>
                                <td><?php echo $tensach; ?></td>
                                <td><?php echo $ngaymuon; ?></td>
                                <td><?php echo $ngaytra; ?></td>
                                <td><?php echo $trangthai; ?></td>
                                <td><strong><?php echo number_format($tienphat, 0, ',', '.'); ?>đ</strong></td>
                            </tr>
                            <?php
                        }
                    }
                ?>
            </tbody>
        </table>

        <div class="alert alert-warning mt-3">
            <h5><strong>Tổng tiền phạt theo độc giả:</strong></h5>
            <ul>
                <?php
                foreach($tongTheoDocGia as $docgia => $tong){
                    echo "<li>{$docgia}: " . number_format($tong, 0, ',', '.') . "đ</li>";
                }
                ?>
            </ul>
        </div>
        <!-- Nút xuất báo cáo -->
        <form method="GET" action="xuatbaocaotienphat.php" class="mt-3">
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
