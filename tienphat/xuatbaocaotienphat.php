<?php 
    require_once "../config.php";
    if(!isset($_SESSION['tk'])){
        header('location: ../dangnhap.php');
        die();
    }

    header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
    header('Content-Disposition: attachment; filename="bao_cao_tien_phat_' . date('Y-m-d_H-i-s') . '.csv"');
    
    $output = fopen('php://output', 'w');
    // Thêm BOM cho UTF-8 (để Excel hiển thị tiếng Việt đúng)
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // Header của báo cáo
    fputcsv($output, array(
        'STT',
        'Tên Độc Giả',
        'Tên Sách',
        'Ngày Mượn',
        'Ngày Trả Hạn',
        'Giá Sách (đ)',
        'Số Ngày Quá Hạn',
        'Tiền Phạt (đ)'
    ), ',');

    $sql = "SELECT mt.id, mt.id_sach, mt.id_dg, mt.ngaymuon, mt.ngaytra, mt.tinhtrang, 
                   dg.tendg, s.tensach, s.gia
            FROM muontra mt
            JOIN docgia dg ON mt.id_dg = dg.id
            JOIN sach s ON mt.id_sach = s.id
            WHERE mt.tinhtrang = 'Chưa trả'
            ORDER BY mt.ngaytra ASC";
    
    $res = mysqli_query($conn, $sql);
    $index = 0;
    $tongtienphat = 0;
    
    if($res == true){
        while($rows = mysqli_fetch_assoc($res)){
            $index++;
            $tendg = $rows['tendg'];
            $tensach = $rows['tensach'];
            $ngaymuon = $rows['ngaymuon'];
            $ngaytra = $rows['ngaytra'];
            $gia = $rows['gia'];
            
            $today = date('Y-m-d');
            $ngaytra_time = strtotime($ngaytra);
            $today_time = strtotime($today);
            $soNgayQuaHan = max(0, ceil(($today_time - $ngaytra_time) / (60 * 60 * 24)));
            $tienphat = $soNgayQuaHan * 1000;
            $tongtienphat += $tienphat;
            
            fputcsv($output, array(
                $index,
                $tendg,
                $tensach,
                $ngaymuon,
                $ngaytra,
                $gia,
                $soNgayQuaHan,
                $tienphat
            ), ',');
        }
    }
    
    // Thêm hàng tổng
    fputcsv($output, array(), ',');
    fputcsv($output, array('', '', '', '', '', '', 'TỔNG TIỀN PHẠT', $tongtienphat), ',');
    
    fclose($output);
    exit;
?>
