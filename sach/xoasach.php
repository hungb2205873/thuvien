<?php 
    require_once '../config.php';
    if(isset($_GET['id'])){

        if(!isset($_SESSION['tk'])){
            header('location: ../dangnhap.php');
            die();
        }

        $id = $_GET['id'];
        $sql = "CALL xoa_sach('$id')";
        $res = mysqli_query($conn,$sql);
        if($res == true){
            $_SESSION['xoasach1']="<div class='text-success' style='font-size:20px'><strong>Xóa sách thành công</strong></div>";
            header('location: hienthisach.php');
        }
        else {
            $_SESSION['xoasach']="<div class='text-danger text-center' style='font-size:20px'><strong>Xóa sách thất bại</strong></div>";
        }
    }
    else { //Truong hop xoa id khien id rong
        header('location: hienthisach.php');
        die();
    }
?>

