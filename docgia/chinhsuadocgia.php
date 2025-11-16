<?php    

    require_once "../config.php";

    if(isset($_GET['id'])){
        if(!isset($_SESSION['tk'])){
            header('location: ../dangnhap.php');
            die();
        }
        $id = $_GET['id'];
        $sql = "SELECT * from docgia where id = $id";
        $res = mysqli_query($conn,$sql);

        //TH id != id trong mang 
        if(mysqli_num_rows($res) == 0) {
            header('location: hienthidocgia.php');
            die();
        }

        $rows = mysqli_fetch_assoc($res);
        $tendg = $rows['tendg'];
        $ngaysinh = $rows['ngaysinh'];
        $diachi = $rows['diachi'];

    }
    else { //Truong hop xoa id khien id rong
        header('location: hienthidocgia.php');
        die();
    }

    if(isset($_POST['save'])){
        $id = $tendg = $ngaysinh = $diachi = '';
        // Lay id tu URL

        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        if(isset($_POST['tendg'])){
            $tendg = $_POST['tendg'];
        }
        if(isset($_POST['ngaysinh'])){
            $ngaysinh = $_POST['ngaysinh'];
        }
        if(isset($_POST['diachi'])){
            $diachi = $_POST['diachi'];
        }


       
        // In hoa tendg
        $tendg = strtoupper($tendg);

        //Fix lỗi SQL Injection
        $tendg = str_replace('\'','\\\'',$tendg);
        $ngaysinh = str_replace('\'','\\\'',$ngaysinh);
        $diachi = str_replace('\'','\\\'',$diachi);

        $sql = "SELECT * from docgia";
        $res = mysqli_query($conn,$sql);
        $trungtensach = 0;
        if($res == true){
            while($rows = mysqli_fetch_assoc($res)){
                if($rows['tendg'] == $tendg){
                    $trungtendocgia = 1;
                }
            }
        }
        if($trungtendocgia == 1){
            $errors['tendg'] = "<div class='text-danger'><i>Độc giả này đã được thêm</i></div>";
        }

        $errors = array();
        if($tendg == ''){
            $errors['tendg'] = "<div class='text-danger'>Bạn chưa nhập tên độc giả.</div>";
        }
        if($ngaysinh == ''){
            $errors['ngaysinh'] = "<div class='text-danger'>Bạn chưa nhập ngày sinh.</div>";
        }
        if($diachi == ''){
            $errors['diachi'] = "<div class='text-danger'>Bạn chưa nhập địa chỉ.</div>";
        }

        if(!$errors){
            $sql = "CALL chinhsuadocgia('$tendg','$ngaysinh','$diachi','$id')";
            $res = mysqli_query($conn,$sql);
            if($res == true){
                $_SESSION['chinhsuadocgia1'] = "<div class='text-success' style='font-size:20px'><strong>Chỉnh sửa độc giả thành công</strong></div>";
                header('location: hienthidocgia.php');
            }
            else {
                $_SESSION['chinhsuadocgia']="<div class='text-danger text-center' style='font-size:20px'><strong>Chỉnh sửa độc giả thất bại</strong></div>";
            }
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
        <a href="hienthidocgia.php" class="btn btn-primary">Quay trở lại</a>
        <h2 class="text-center bg-success text-white mt-4 mb-4">CHỈNH SỬA ĐỘC GIẢ</h2>

        <?php 
            if(isset($_SESSION['chinhsuadocgia1'])){
                echo $_SESSION['chinhsuadocgia1'];
                unset($_SESSION['chinhsuadocgia1']);
            }
        ?>

        <form  method="POST">
            <div class="row mb-5">
                <label for="tendg" class="form-label col-sm-2 text-end "><strong>Nhập tên độc giả</strong></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="tendg" placeholder="Nhập tên độc giả" name="tendg" value="<?php if(isset($tendg)) {echo $tendg;} ?>">
                    <?php 
                        if(isset($errors['tendg'])){
                            echo $errors['tendg'];
                        }
                    ?>
                </div>
            </div>

            <div class="row mb-5">
                <label for="ngaysinh" class="form-label col-sm-2 text-end "><strong>Nhập ngày sinh</strong></label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" id="ngaysinh" placeholder="Nhập ngày sinh" name="ngaysinh" value="<?php if(isset($ngaysinh)) {echo $ngaysinh;} ?>">
                    <?php 
                        if(isset($errors['ngaysinh'])){
                            echo $errors['ngaysinh'];
                        }
                    ?>
                </div>
            </div>

            <div class="row mb-5">
                <label for="diachi" class="form-label col-sm-2 text-end "><strong>Nhập địa chỉ</strong></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="diachi" placeholder="Nhập địa chỉ" name="diachi" value="<?php if(isset($diachi)) {echo $diachi;} ?>">
                    <?php 
                        if(isset($errors['diachi'])){
                            echo $errors['diachi'];
                        }
                    ?>
                </div>
            </div>

            <button class="btn btn-success offset-sm-2" name="save">Lưu lại</button>

        </form>
    </div>
</body>
</html>