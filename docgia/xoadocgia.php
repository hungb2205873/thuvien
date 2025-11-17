<?php 
    require_once '../config.php';
    if(isset($_GET['id'])){
        if(!isset($_SESSION['tk'])){
            header('location: ../dangnhap.php');
            die();
        }

        $id = $_GET['id'];
        // Gọi procedure mới
        $sql = "CALL XoaDocGia('$id')";
        $res = mysqli_query($conn,$sql);

        if($res){
            $_SESSION['xoadocgia1']="<div class='text-success' style='font-size:20px'><strong>Xóa độc giả thành công</strong></div>";
            header('location: hienthidocgia.php');
            exit;
        } else {
            $_SESSION['xoadocgia']="<div class='text-danger text-center' style='font-size:20px'><strong>Xóa độc giả thất bại</strong></div>";
            header('location: hienthidocgia.php');
            exit;
        }
    } else {
        header('location: hienthidocgia.php');
        die();
    }
?>
