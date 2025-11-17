<?php
    require_once "../config.php";

    if(!isset($_SESSION['tk'])){
        header('location: ../dangnhap.php');
        die();
    }

    if(isset($_GET['id'])){
        $id = (int)$_GET['id'];

        // Xóa chi tiết phiếu mượn trước
        $sql_ct = "DELETE FROM chi_tiet_phieu_muon WHERE ma_phieu_muon = $id";
        $res_ct = mysqli_query($conn, $sql_ct);

        // Sau đó xóa phiếu mượn
        $sql_pm = "DELETE FROM phieu_muon WHERE ma_phieu_muon = $id";
        $res_pm = mysqli_query($conn, $sql_pm);

        if($res_pm){
            $_SESSION['xoamuontra1'] = "<div class='text-success' style='font-size:20px'><strong>Xóa phiếu mượn thành công</strong></div>";
        } else {
            $_SESSION['xoamuontra'] = "<div class='text-danger' style='font-size:20px'><strong>Xóa phiếu mượn thất bại</strong></div>";
        }

        header('location: hienthimuontra.php');
        exit;
    } else {
        header('location: hienthimuontra.php');
        die();
    }
?>
