<?php
require_once "../config.php";
if(!isset($_SESSION['tk'])){
    header('location: ../dangnhap.php');
    die();
}

// Lấy tham số tháng/năm nếu có
$thang = $_GET['thang'] ?? date('m');
$nam   = $_GET['nam'] ?? date('Y');

// Thiết lập header để tải file Excel
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=baocao_tienphat_{$thang}_{$nam}.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Truy vấn dữ liệu từ phieu_muon với trạng thái Trả muộn
$sql = "SELECT dg.ten_doc_gia, s.ten_sach, pm.ngay_muon, pm.ngay_tra, pm.trang_thai
        FROM phieu_muon pm
        JOIN doc_gia dg ON pm.ma_doc_gia = dg.ma_doc_gia
        JOIN chi_tiet_phieu_muon ct ON pm.ma_phieu_muon = ct.ma_phieu_muon
        JOIN sach s ON ct.ma_sach = s.ma_sach
        WHERE pm.trang_thai = 'Trả muộn'
          AND MONTH(pm.ngay_tra) = '$thang'
          AND YEAR(pm.ngay_tra) = '$nam'
        ORDER BY pm.ngay_tra ASC";

$res = mysqli_query($conn, $sql);

// Xuất bảng
echo "<table border='1'>";
echo "<tr>
        <th>STT</th>
        <th>Tên Độc Giả</th>
        <th>Tên Sách</th>
        <th>Ngày Mượn</th>
        <th>Ngày Trả</th>
        <th>Trạng Thái</th>
        <th>Tiền Phạt</th>
      </tr>";

$index = 0;
$tongtienphat = 0;
if($res && mysqli_num_rows($res) > 0){
    while($row = mysqli_fetch_assoc($res)){
        $index++;
        $tienphat = 10000; // mặc định 10,000đ
        $tongtienphat += $tienphat;

        echo "<tr>";
        echo "<td>{$index}</td>";
        echo "<td>{$row['ten_doc_gia']}</td>";
        echo "<td>{$row['ten_sach']}</td>";
        echo "<td>{$row['ngay_muon']}</td>";
        echo "<td>{$row['ngay_tra']}</td>";
        echo "<td>{$row['trang_thai']}</td>";
        echo "<td>".number_format($tienphat,0,',','.')."đ</td>";
        echo "</tr>";
    }
    // Dòng tổng tiền phạt
    echo "<tr><td colspan='6'><strong>Tổng tiền phạt</strong></td>
              <td><strong>".number_format($tongtienphat,0,',','.')."đ</strong></td></tr>";
} else {
    echo "<tr><td colspan='7'>Không có dữ liệu báo cáo cho tháng {$thang}/{$nam}</td></tr>";
}
echo "</table>";
?>
