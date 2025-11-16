<?php 
    require_once "../config.php";
    if(!isset($_SESSION['tk'])){
        header('location: ../dangnhap.php');
        die();
    }
    if(isset($_POST['save'])){
        $tensach = $tentg = $nhaxuatban = $ngayxb = $soluong = $tomtat = '';
        if(isset($_POST['tensach'])){
            $tensach = $_POST['tensach'];
        }
        if(isset($_POST['tentg'])){
            $tentg = $_POST['tentg'];
        }
        if(isset($_POST['nhaxuatban'])){
            $nhaxuatban = $_POST['nhaxuatban'];
        }
        if(isset($_POST['ngayxb'])){
            $ngayxb = $_POST['ngayxb'];
        }
        if(isset($_POST['soluong'])){
            $soluong = $_POST['soluong'];
        }
        if(isset($_POST['tomtat'])){
            $tomtat = $_POST['tomtat'];
        }

        
        // In hoa tensach
        $tensach = strtoupper($tensach);

        //Fix lỗi SQL Injection
        $tensach = str_replace('\'','\\\'',$tensach);
        $tentg = str_replace('\'','\\\'',$tentg);
        $nhaxuatban = str_replace('\'','\\\'',$nhaxuatban);
        $ngayxb = str_replace('\'','\\\'',$ngayxb);
        $soluong = str_replace('\'','\\\'',$soluong);
        $tomtat = str_replace('\'','\\\'',$tomtat);

        $sql = "SELECT * from sach";
        $res = mysqli_query($conn,$sql);
        $trungtensach = 0;
        if($res == true){
            while($rows = mysqli_fetch_assoc($res)){
                if($rows['tensach'] == $tensach){
                    $trungtensach = 1;
                }
            }
        }
        if($trungtensach == 1){
            $errors['tensach'] = "<div class='text-danger'><i>Sách đã được thêm</i></div>";
        }

        $errors = array();
        if($tensach == ''){
            $errors['tensach'] = "<div class='text-danger'>Bạn chưa nhập tên sách.</div>";
        }
        if($tentg == ''){
            $errors['tentg'] = "<div class='text-danger'>Bạn chưa nhập tên tác giả.</div>";
        }
        if($nhaxuatban == ''){
            $errors['nhaxuatban'] = "<div class='text-danger'>Bạn chưa nhập nhà xuất bản.</div>";
        }
        if($ngayxb == ''){
            $errors['ngayxb'] = "<div class='text-danger'>Bạn chưa nhập ngày xuất bản.</div>";
        }
        if($soluong == ''){
            $errors['soluong'] = "<div class='text-danger'>Bạn chưa nhập số lượng sách.</div>";
        }
        if($tomtat == ''){
            $errors['tomtat'] = "<div class='text-danger'>Bạn chưa nhập bản tóm tắt.</div>";
        }
        
        if(!$errors){
            $sql = "CALL themsach('$tensach','$tentg','$nhaxuatban','$ngayxb','$soluong','$tomtat')";
            $res = mysqli_query($conn,$sql);
            if($res == true){
                $_SESSION['themsach1'] = "<div class='text-success' style='font-size:20px'><strong>Bạn đã thêm sách thành công</strong></div>";
                header('location: hienthisach.php');
            }
            
        }else{
            $_SESSION['themsach'] = "<div class='text-danger text-center' style='font-size:20px'><strong>Thêm sách thất bại</strong></div>";
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUẢN LÍ SÁCH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <div class="container mt-3">
        <a href="hienthisach.php" class="btn btn-primary">Quay trở lại</a>
        <h2 class="text-center mt-3 text-white mb-3" style="background: linear-gradient(to right, #6EC6FF, #6A1B9A);">thêm sách</h2>

        <form  method="POST">
            <div class="row mb-5">
                <label for="tensach" class="form-label col-sm-2 text-end "><strong>Nhập tên sách</strong></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="tensach" placeholder="Nhập tên sách" name="tensach" value="<?php if(isset($tensach)) {echo $tensach;} ?>">
                    <?php 
                        if(isset($errors['tensach'])){
                            echo $errors['tensach'];
                        }
                    ?>
                </div>
            </div>

            <div class="row mb-5">
                <label for="tentg" class="form-label col-sm-2 text-end "><strong>Nhập tên tác giả</strong></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="tentg" placeholder="Nhập tên tác giả" name="tentg" value="<?php if(isset($tentg)) {echo $tentg;} ?>">
                    <?php 
                        if(isset($errors['tentg'])){
                            echo $errors['tentg'];
                        }
                    ?>
                </div>
            </div>

            <div class="row mb-5">
                <label for="nhaxuatban" class="form-label col-sm-2 text-end "><strong>Nhập tên NXB</strong></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nhaxuatban" placeholder="Nhập tên nhà xuất bản" name="nhaxuatban" value="<?php if(isset($nhaxuatban)) {echo $nhaxuatban;} ?>">
                    <?php 
                        if(isset($errors['nhaxuatban'])){
                            echo $errors['nhaxuatban'];
                        }
                    ?>
                </div>
            </div>
            
            <div class="row mb-5">
                <label for="ngayxb" class="form-label col-sm-2 text-end "><strong>Nhập ngày xuất bản</strong></label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" id="ngayxb" placeholder="Nhập ngày xuất bản" name="ngayxb" value="<?php if(isset($ngayxb)) {echo $ngayxb;} ?>">
                    <?php 
                        if(isset($errors['ngayxb'])){
                            echo $errors['ngayxb'];
                        }
                    ?>
                </div>
            </div>
            
            <div class="row mb-5">
                <label for="soluong" class="form-label col-sm-2 text-end "><strong>Nhập số trang</strong></label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" id="soluong" placeholder="Nhập số trang" name="soluong" value="<?php if(isset($sotrang)) {echo $sotrang;} ?>">
                    <?php 
                        if(isset($errors['soluong'])){
                            echo $errors['soluong'];
                        }
                    ?>
                </div>
            </div>

            <div class="row mb-5">
                <label for="tomtat" class="form-label col-sm-2 text-end "><strong>Nhập bản tóm tắt</strong></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="tomtat" placeholder="Nhập bản tóm tắt" name="tomtat" value="<?php if(isset($tomtat)) {echo $tomtat;} ?>">
                    <?php 
                        if(isset($errors['tomtat'])){
                            echo $errors['tomtat'];
                        }
                    ?>
                </div>
            </div>

            <button class="btn btn-success offset-sm-2" name="save">Lưu lại</button>
        </form>
    </div>
    
</body>
</html>