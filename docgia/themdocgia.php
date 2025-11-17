<?php 
    require_once "../config.php";
    if(!isset($_SESSION['tk'])){
        header('location: ../dangnhap.php');
        die();
    }

    if(isset($_POST['save'])){
        $tendg = $_POST['tendg'] ?? '';
        $ngaysinh = $_POST['ngaysinh'] ?? '';
        $sdt = $_POST['sdt'] ?? '';
        $email = $_POST['email'] ?? '';

        $errors = [];

        if($tendg == '') $errors['tendg'] = "<div class='text-danger'>Bạn chưa nhập tên độc giả.</div>";
        if($ngaysinh == '') $errors['ngaysinh'] = "<div class='text-danger'>Bạn chưa nhập ngày sinh.</div>";
        if($sdt == '') $errors['sdt'] = "<div class='text-danger'>Bạn chưa nhập số điện thoại.</div>";
        if($email == '') $errors['email'] = "<div class='text-danger'>Bạn chưa nhập email.</div>";

        if(!$errors){
            // Thêm độc giả vào bảng doc_gia
            $sql = "INSERT INTO doc_gia (ten_doc_gia, ngay_sinh, so_dien_thoai, email) 
                    VALUES ('$tendg','$ngaysinh','$sdt','$email')";
            $res = mysqli_query($conn,$sql);
            if($res){
                $_SESSION['themdocgia1'] = "<div class='text-success' style='font-size:20px'><strong>Bạn đã thêm độc giả thành công</strong></div>";
                header('location: hienthidocgia.php');
                exit;
            } else {
                $_SESSION['themdocgia'] = "<div class='text-danger text-center' style='font-size:20px'><strong>Thêm độc giả thất bại</strong></div>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>THÊM ĐỘC GIẢ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-3">
        <a href="hienthidocgia.php" class="btn btn-primary">Quay trở lại</a>
        <h2 class="text-center mt-3 text-white mb-3" style="background: linear-gradient(to right, #6EC6FF, #6A1B9A);">Thêm độc giả</h2>

        <?php 
            if(isset($_SESSION['themdocgia1'])){
                echo $_SESSION['themdocgia1'];
                unset($_SESSION['themdocgia1']);
            }
            if(isset($_SESSION['themdocgia'])){
                echo $_SESSION['themdocgia'];
                unset($_SESSION['themdocgia']);
            }
        ?>

        <form method="POST">
            <div class="row mb-3">
                <label for="tendg" class="form-label col-sm-2 text-end"><strong>Tên độc giả</strong></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="tendg" name="tendg" value="<?php if(isset($tendg)) echo $tendg; ?>">
                    <?php if(isset($errors['tendg'])) echo $errors['tendg']; ?>
                </div>
            </div>

            <div class="row mb-3">
                <label for="ngaysinh" class="form-label col-sm-2 text-end"><strong>Ngày sinh</strong></label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" id="ngaysinh" name="ngaysinh" value="<?php if(isset($ngaysinh)) echo $ngaysinh; ?>">
                    <?php if(isset($errors['ngaysinh'])) echo $errors['ngaysinh']; ?>
                </div>
            </div>

            <div class="row mb-3">
                <label for="sdt" class="form-label col-sm-2 text-end"><strong>Số điện thoại</strong></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="sdt" name="sdt" value="<?php if(isset($sdt)) echo $sdt; ?>">
                    <?php if(isset($errors['sdt'])) echo $errors['sdt']; ?>
                </div>
            </div>

            <div class="row mb-3">
                <label for="email" class="form-label col-sm-2 text-end"><strong>Email</strong></label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" value="<?php if(isset($email)) echo $email; ?>">
                    <?php if(isset($errors['email'])) echo $errors['email']; ?>
                </div>
            </div>

            <button class="btn btn-success offset-sm-2" name="save">Lưu lại</button>
        </form>
    </div>
</body>
</html>
