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
    <title>Tìm kiếm sách</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>a { text-decoration:none; }</style>
</head>
<body>
<div class="container mt-3">
    <a href="hienthisach.php" class="btn btn-primary mb-3">Quay lại danh sách</a>
    <h2 class="text-center text-white mb-4" style="background: linear-gradient(to right, #6EC6FF, #6A1B9A);">📚 BookHub - Tìm kiếm sách</h2>

    <?php
    $ten_sach = $_GET['ten_sach'] ?? '';
    $tac_gia  = $_GET['tac_gia'] ?? '';
    $the_loai = $_GET['the_loai'] ?? '';

    // Xây dựng điều kiện WHERE linh hoạt
    $conditions = [];
    if($ten_sach != ''){
        $conditions[] = "s.ten_sach LIKE '%$ten_sach%'";
    }
    if($tac_gia != ''){
        $conditions[] = "tg.ten_tac_gia LIKE '%$tac_gia%'";
    }
    if($the_loai != ''){
        $conditions[] = "tl.ten_the_loai LIKE '%$the_loai%'";
    }

    $where = '';
    if(count($conditions) > 0){
        $where = "WHERE " . implode(" AND ", $conditions);
    }

    $sql = "SELECT s.ma_sach, s.ten_sach, s.nha_xuat_ban, s.nam_xuat_ban, s.so_luong,
                   tg.ten_tac_gia, tl.ten_the_loai
            FROM sach s
            JOIN tac_gia tg ON s.ma_tac_gia = tg.ma_tac_gia
            JOIN the_loai tl ON s.ma_the_loai = tl.ma_the_loai
            $where
            ORDER BY s.ten_sach ASC";

    $res = mysqli_query($conn,$sql);
    ?>

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
        $index = 0;
        if($res && mysqli_num_rows($res) > 0){
            while($rows = mysqli_fetch_assoc($res)){
                $index++;
                $id        = $rows['ma_sach'];
                echo "<tr>
                        <td>{$index}</td>
                        <td>{$rows['ten_sach']}</td>
                        <td>{$rows['ten_tac_gia']}</td>
                        <td>{$rows['nha_xuat_ban']}</td>
                        <td>{$rows['nam_xuat_ban']}</td>
                        <td>{$rows['so_luong']}</td>
                        <td>{$rows['ten_the_loai']}</td>
                        <td>
                            <a class='btn btn-warning btn-sm' href='chinhsuasach.php?id={$id}'>sửa</a>
                            <a class='btn btn-danger btn-sm' href='xoasach.php?id={$id}'>xóa</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Không tìm thấy kết quả phù hợp.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
