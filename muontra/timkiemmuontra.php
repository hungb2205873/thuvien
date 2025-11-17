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
    <title>Tìm kiếm mượn trả</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        a { text-decoration:none; }
    </style>
</head>
<body>
    <div class="container mt-3">
        <a href="hienthimuontra.php" class="btn btn-primary mb-3">Quay lại danh sách</a>
        <h2 class="text-center text-white mb-4" style="background: linear-gradient(to right, #6EC6FF, #6A1B9A);">
            📚 BookHub
        </h2>

        <?php
        $search_sach   = $_GET['timkiem_sach'] ?? '';
        $search_docgia = $_GET['timkiem_docgia'] ?? '';

        // Xây dựng điều kiện WHERE linh hoạt
        $conditions = [];
        if($search_sach != ''){
            $conditions[] = "s.ten_sach LIKE '%$search_sach%'";
        }
        if($search_docgia != ''){
            $conditions[] = "dg.ten_doc_gia LIKE '%$search_docgia%'";
        }

        $where = '';
        if(count($conditions) > 0){
            $where = "WHERE " . implode(" AND ", $conditions);
        }

        $sql = "SELECT pm.ma_phieu_muon, s.ten_sach, dg.ten_doc_gia, pm.ngay_muon, pm.ngay_tra, pm.trang_thai
                FROM phieu_muon pm
                JOIN doc_gia dg ON pm.ma_doc_gia = dg.ma_doc_gia
                JOIN chi_tiet_phieu_muon ct ON pm.ma_phieu_muon = ct.ma_phieu_muon
                JOIN sach s ON ct.ma_sach = s.ma_sach
                $where
                ORDER BY pm.ngay_muon ASC";

        $res = mysqli_query($conn,$sql);
        ?>

        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sách</th>
                    <th>Tên độc giả</th>
                    <th>Ngày mượn</th>
                    <th>Ngày trả</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 0;
                if($res && mysqli_num_rows($res) > 0){
                    while($rows = mysqli_fetch_assoc($res)){
                        $index++;
                        $id = $rows['ma_phieu_muon'];
                        echo "<tr>";
                        echo "<td>{$index}</td>";
                        echo "<td>{$rows['ten_sach']}</td>";
                        echo "<td>{$rows['ten_doc_gia']}</td>";
                        echo "<td>{$rows['ngay_muon']}</td>";
                        echo "<td>{$rows['ngay_tra']}</td>";
                        echo "<td>{$rows['trang_thai']}</td>";
                        echo "<td>
                                <a class='btn btn-warning btn-sm' href='chinhsuamuontra.php?id={$id}'>sửa</a>
                                <a class='btn btn-danger btn-sm' href='xoamuontra.php?id={$id}'>xóa</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Không tìm thấy kết quả phù hợp.</td></tr>";
                }
                ?>
            </tbody>
        </table>

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
