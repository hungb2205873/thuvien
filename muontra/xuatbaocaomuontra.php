<?php
require_once "../config.php";
if(!isset($_SESSION['tk'])){
    header('location: ../dangnhap.php');
    die();
}

// Lấy tham số tháng/năm từ form
$thang = $_GET['thang'] ?? date('m');
$nam   = $_GET['nam'] ?? date('Y');

// Thiết lập header để tải file Excel
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=baocao_muontra_{$thang}_{$nam}.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Truy vấn dữ liệu phiếu mượn theo tháng/năm
$sql = "SELECT s.ten_sach, dg.ten_doc_gia, pm.ngay_muon, pm.ngay_tra, pm.trang_thai
        FROM phieu_muon pm
        JOIN doc_gia dg ON pm.ma_doc_gia = dg.ma_doc_gia
        JOIN chi_tiet_phieu_muon ct ON pm.ma_phieu_muon = ct.ma_phieu_muon
        JOIN sach s ON ct.ma_sach = s.ma_sach
        WHERE MONTH(pm.ngay_muon) = '$thang'
          AND YEAR(pm.ngay_muon) = '$nam'
        ORDER BY pm.ngay_muon ASC";

$res = mysqli_query($conn, $sql);

// Xuất bảng
echo "<table border='1'>";
echo "<tr>
        <th>STT</th>
        <th>Tên sách</th>
        <th>Tên Độc Giả</th>
        <th>Ngày mượn</th>
        <th>Ngày trả</th>
        <th>Trạng Thái</th>
      </tr>";

$index = 0;
if($res && mysqli_num_rows($res) > 0){
    while($row = mysqli_fetch_assoc($res)){
        $index++;
        echo "<tr>";
        echo "<td>{$index}</td>";
        echo "<td>{$row['ten_sach']}</td>";
        echo "<td>{$row['ten_doc_gia']}</td>";
        echo "<td>{$row['ngay_muon']}</td>";
        echo "<td>{$row['ngay_tra']}</td>";
        echo "<td>{$row['trang_thai']}</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>Không có dữ liệu báo cáo cho tháng {$thang}/{$nam}</td></tr>";
}
echo "</table>";
?>
