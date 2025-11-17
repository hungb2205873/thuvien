<?php
require_once "../config.php";
if(!isset($_SESSION['tk'])){
    header('location: ../dangnhap.php');
    die();
}

$thang = $_GET['thang'] ?? date('m');
$nam   = $_GET['nam'] ?? date('Y');

// Thiết lập header để tải file Excel
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=baocao_muontra_{$thang}_{$nam}.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Gọi procedure
$sql = "CALL XuatBaoCaoMuonTra($thang, $nam)";
$res = mysqli_query($conn, $sql);

echo "<table border='1'>";
echo "<tr>
        <th>Mã phiếu mượn</th>
        <th>Mã độc giả</th>
        <th>Mã sách</th>
        <th>Ngày mượn</th>
        <th>Ngày trả dự kiến</th>
        <th>Ngày trả thực tế</th>
        <th>Trạng thái</th>
        <th>Tiền phạt</th>
        <th>Số lần mượn</th>
      </tr>";

if($res && mysqli_num_rows($res) > 0){
    while($row = mysqli_fetch_assoc($res)){
        echo "<tr>";
        echo "<td>{$row['ma_phieu_muon']}</td>";
        echo "<td>{$row['ma_doc_gia']}</td>";
        echo "<td>{$row['ma_sach']}</td>";
        echo "<td>{$row['ngay_muon']}</td>";
        echo "<td>{$row['ngay_tra_du_kien']}</td>";
        echo "<td>{$row['ngay_tra_thuc_te']}</td>";
        echo "<td>{$row['trang_thai']}</td>";
        echo "<td>".number_format($row['tien_phat'],0,',','.')."đ</td>";
        echo "<td>{$row['so_lan_muon']}</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='9'>Không có dữ liệu báo cáo cho tháng {$thang}/{$nam}</td></tr>";
}
echo "</table>";

// Sau khi gọi procedure, cần giải phóng kết quả để tránh lỗi "Commands out of sync"
mysqli_free_result($res);
mysqli_next_result($conn);
?>
