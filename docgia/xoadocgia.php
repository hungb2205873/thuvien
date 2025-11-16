<?php 
    require_once '../config.php';
    if(isset($_GET['id'])){

        if(!isset($_SESSION['tk'])){
            header('location: ../dangnhap.php');
            die();
        }

        $id = $_GET['id'];
        $sql = "CALL xoadocgia('$id')";
        $res = mysqli_query($conn,$sql);
        if($res == true){
            $_SESSION['xoadocgia1']="<div class='text-success' style='font-size:20px'><strong>Xóa độc giả thành công</strong></div>";
            header('location: hienthidocgia.php');
        }
        else {
            $_SESSION['xoadocgia']="<div class='text-danger text-center' style='font-size:20px'><strong>Xóa độc giả thất bại</strong></div>";
        }
    }
    else { //Truong hop xoa id khien id rong
        header('location: hienthidocgia.php');
        die();
    }
?>

