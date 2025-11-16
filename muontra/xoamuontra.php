<?php 
    require_once '../config.php';
    if(isset($_GET['id'])){

        if(!isset($_SESSION['tk'])){
            header('location: ../dangnhap.php');
            die();
        }

        $id = $_GET['id'];
        $sql = "CALL xoamuontra('$id')";
        $res = mysqli_query($conn,$sql);
        if($res == true){
            $_SESSION['xoamuontra1']="<div class='text-success' style='font-size:20px'><strong>Xóa thành công</strong></div>";
            header('location: hienthimuontra.php');
        }
        else {
            $_SESSION['xoamuontra']="<div class='text-danger text-center' style='font-size:20px'><strong>Xóa thất bại</strong></div>";
        }
    }
    else { //Truong hop xoa id khien id rong
        header('location: hienthimuontra.php');
        die();
    }
?>