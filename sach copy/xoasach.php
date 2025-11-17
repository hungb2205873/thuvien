<?php
    require_once "../config.php";

    if(!isset($_SESSION['tk'])){
        header('location: ../dangnhap.php');
        die();
    }

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        // Nếu không có procedure, dùng DELETE trực tiếp
        $sql = "DELETE FROM sach WHERE ma_sach = $id";
        $res = mysqli_query($conn, $sql);

        if($res){
            $_SESSION['xoasach1'] = "<div class='text-success'><strong>Xóa sách thành công</strong></div>";
        } else {
            $_SESSION['xoasach'] = "<div class='text-danger'><strong>Xóa sách thất bại</strong></div>";
        }
    } else {
        $_SESSION['xoasach'] = "<div class='text-danger'><strong>Không tìm thấy sách để xóa</strong></div>";
    }

    header('location: hienthisach.php');
    exit;
?>
