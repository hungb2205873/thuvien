<?php    
require_once "../config.php";

if(!isset($_SESSION['tk'])){
    header('location: ../dangnhap.php');
    die();
}

if(isset($_GET['id'])){
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM doc_gia WHERE ma_doc_gia = $id";
    $res = mysqli_query($conn,$sql);

    if(mysqli_num_rows($res) == 0) {
        header('location: hienthidocgia.php');
        die();
    }

    $rows = mysqli_fetch_assoc($res);
    $tendg    = $rows['ten_doc_gia'];
    $ngaysinh = $rows['ngay_sinh'];
    $sdt      = $rows['so_dien_thoai'];
    $email    = $rows['email'];
    $mat_khau = $rows['mat_khau']; // lấy mật khẩu hiện tại
} else {
    header('location: hienthidocgia.php');
    die();
}

$errors = array();

if(isset($_POST['save'])){
    $tendg    = trim($_POST['tendg'] ?? '');
    $ngaysinh = trim($_POST['ngaysinh'] ?? '');
    $sdt      = trim($_POST['sdt'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $mat_khau = trim($_POST['mat_khau'] ?? '');

    // Escape dữ liệu
    $tendg    = mysqli_real_escape_string($conn, $tendg);
    $ngaysinh = mysqli_real_escape_string($conn, $ngaysinh);
    $sdt      = mysqli_real_escape_string($conn, $sdt);
    $email    = mysqli_real_escape_string($conn, $email);
    $mat_khau = mysqli_real_escape_string($conn, $mat_khau);

    // Kiểm tra trùng tên độc giả (trừ chính mình)
    $sql_check = "SELECT * FROM doc_gia WHERE ten_doc_gia = '$tendg' AND ma_doc_gia != $id";
    $res_check = mysqli_query($conn,$sql_check);
    if(mysqli_num_rows($res_check) > 0){
        $errors['tendg'] = "<div class='text-danger'><i>Độc giả này đã tồn tại</i></div>";
    }

    // Kiểm tra rỗng
    if($tendg == '')    $errors['tendg']    = "<div class='text-danger'>Bạn chưa nhập tên độc giả.</div>";
    if($ngaysinh == '') $errors['ngaysinh'] = "<div class='text-danger'>Bạn chưa nhập ngày sinh.</div>";
    if($sdt == '')      $errors['sdt']      = "<div class='text-danger'>Bạn chưa nhập số điện thoại.</div>";
    if($email == '')    $errors['email']    = "<div class='text-danger'>Bạn chưa nhập email.</div>";

    // Nếu mật khẩu rỗng thì truyền NULL
    if($mat_khau == ''){
        $mat_khau_sql = "NULL";
    } else {
        $mat_khau_sql = "'$mat_khau'";
    }

    if(!$errors){
        // Gọi procedure cập nhật với đủ 6 tham số
        $sql = "CALL CapNhatDocGia('$id','$tendg','$ngaysinh','$sdt','$email',$mat_khau_sql)";
        $res = mysqli_query($conn,$sql);
        if($res){
            $_SESSION['chinhsuadocgia1'] = "<div class='text-success' style='font-size:20px'><strong>Chỉnh sửa độc giả thành công</strong></div>";
            header('location: hienthidocgia.php');
            exit;
        } else {
            $_SESSION['chinhsuadocgia'] = "<div class='text-danger text-center' style='font-size:20px'><strong>Chỉnh sửa độc giả thất bại</strong></div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>QUẢN LÍ ĐỘC GIẢ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
   <!-- Header -->
   <nav class="navbar navbar-expand-lg navbar-light shadow-sm sticky-top" style="background: linear-gradient(to right, #6EC6FF, #6A1B9A);">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="../index.php">
                <span class="text-gradient">📚 BookHub</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="btn btn-primary mt-2" href="../dangxuat.php">Đăng xuất</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-3">
        <a href="hienthidocgia.php" class="btn btn-primary">Quay trở lại</a>
        <h2 class="text-center bg-success text-white mt-4 mb-4">CHỈNH SỬA ĐỘC GIẢ</h2>

        <?php 
            if(isset($_SESSION['chinhsuadocgia1'])){
                echo $_SESSION['chinhsuadocgia1'];
                unset($_SESSION['chinhsuadocgia1']);
            }
            if(isset($_SESSION['chinhsuadocgia'])){
                echo $_SESSION['chinhsuadocgia'];
                unset($_SESSION['chinhsuadocgia']);
            }
        ?>

        <form method="POST">
            <div class="row mb-3">
                <label for="tendg" class="form-label col-sm-2 text-end"><strong>Tên độc giả</strong></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="tendg" name="tendg" value="<?php echo htmlspecialchars($tendg); ?>">
                    <?php if(isset($errors['tendg'])) echo $errors['tendg']; ?>
                </div>
            </div>

            <div class="row mb-3">
                <label for="ngaysinh" class="form-label col-sm-2 text-end"><strong>Ngày sinh</strong></label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" id="ngaysinh" name="ngaysinh" value="<?php echo htmlspecialchars($ngaysinh); ?>">
                    <?php if(isset($errors['ngaysinh'])) echo $errors['ngaysinh']; ?>
                </div>
            </div>

            <div class="row mb-3">
                <label for="sdt" class="form-label col-sm-2 text-end"><strong>Số điện thoại</strong></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="sdt" name="sdt" value="<?php echo htmlspecialchars($sdt); ?>">
                    <?php if(isset($errors['sdt'])) echo $errors['sdt']; ?>
                </div>
            </div>

            <div class="row mb-3">
                <label for="email" class="form-label col-sm-2 text-end"><strong>Email</strong></label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                    <?php if(isset($errors['email'])) echo $errors['email']; ?>
                </div>
            </div>

            <div class="row mb-3">
                <label for="mat_khau" class="form-label col-sm-2 text-end"><strong>Mật khẩu (để trống nếu giữ nguyên)</strong></label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="mat_khau" name="mat_khau" value="">
                    <?php if(isset($errors['mat_khau'])) echo $errors['mat_khau']; ?>
                </div>
            </div>

            <button class="btn btn-success offset-sm-2" name="save">Lưu lại</button>
        </form>
    </div>
</body>
</html>
