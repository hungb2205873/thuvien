<?php 
    require_once "../config.php";
    if(!isset($_SESSION['tk'])){
        header('location: ../dangnhap.php');
        die();
    }

    // Lấy danh sách thể loại
    $sql_tl = "SELECT * FROM the_loai";
    $res_tl = mysqli_query($conn,$sql_tl);

   if(isset($_POST['save'])){
    $tensach = $tentg = $nhaxuatban = $ngayxb = $soluong = $theloai = '';
    if(isset($_POST['tensach']))    $tensach = $_POST['tensach'];
    if(isset($_POST['tentg']))      $tentg = $_POST['tentg'];
    if(isset($_POST['nhaxuatban'])) $nhaxuatban = $_POST['nhaxuatban'];
    if(isset($_POST['ngayxb']))     $ngayxb = $_POST['ngayxb'];
    if(isset($_POST['soluong']))    $soluong = $_POST['soluong'];
    if(isset($_POST['theloai']))    $theloai = $_POST['theloai'];

    // Ngày thêm = ngày hiện tại
    $ngaythem = date('Y-m-d');

    // In hoa tensach
    $tensach = strtoupper($tensach);

    $errors = array();
    if($tensach == '')    $errors['tensach']    = "<div class='text-danger'>Bạn chưa nhập tên sách.</div>";
    if($tentg == '')      $errors['tentg']      = "<div class='text-danger'>Bạn chưa nhập tên tác giả.</div>";
    if($nhaxuatban == '') $errors['nhaxuatban'] = "<div class='text-danger'>Bạn chưa nhập nhà xuất bản.</div>";
    if($ngayxb == '')     $errors['ngayxb']     = "<div class='text-danger'>Bạn chưa nhập ngày xuất bản.</div>";
    if($soluong == '')    $errors['soluong']    = "<div class='text-danger'>Bạn chưa nhập số lượng sách.</div>";
    if($theloai == '')    $errors['theloai']    = "<div class='text-danger'>Bạn chưa chọn thể loại.</div>";

    if(!$errors){
        // Gọi procedure themsach với đủ 7 tham số
        $sql = "CALL themsach('$tensach','$tentg','$nhaxuatban','$ngayxb','$soluong','$theloai','$ngaythem')";
        $res = mysqli_query($conn,$sql);
        if($res == true){
            $_SESSION['themsach1'] = "<div class='text-success' style='font-size:20px'><strong>Bạn đã thêm sách thành công</strong></div>";
            header('location: hienthisach.php');
            exit;
        } else {
            $_SESSION['themsach'] = "<div class='text-danger text-center' style='font-size:20px'><strong>Thêm sách thất bại</strong></div>";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>QUẢN LÍ SÁCH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-3">
        <a href="hienthisach.php" class="btn btn-primary">Quay trở lại</a>
        <h2 class="text-center mt-3 text-white mb-3" style="background: linear-gradient(to right, #6EC6FF, #6A1B9A);">Thêm sách</h2>

        <form method="POST">
            <div class="row mb-3">
                <label for="tensach" class="form-label col-sm-2 text-end"><strong>Tên sách</strong></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="tensach" name="tensach" value="<?php echo $tensach ?? ''; ?>">
                    <?php if(isset($errors['tensach'])) echo $errors['tensach']; ?>
                </div>
            </div>

            <div class="row mb-3">
                <label for="tentg" class="form-label col-sm-2 text-end"><strong>Tác giả</strong></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="tentg" name="tentg" value="<?php echo $tentg ?? ''; ?>">
                    <?php if(isset($errors['tentg'])) echo $errors['tentg']; ?>
                </div>
            </div>

            <div class="row mb-3">
                <label for="nhaxuatban" class="form-label col-sm-2 text-end"><strong>Nhà xuất bản</strong></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nhaxuatban" name="nhaxuatban" value="<?php echo $nhaxuatban ?? ''; ?>">
                    <?php if(isset($errors['nhaxuatban'])) echo $errors['nhaxuatban']; ?>
                </div>
            </div>

            <div class="row mb-3">
                <label for="ngayxb" class="form-label col-sm-2 text-end"><strong>Ngày xuất bản</strong></label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" id="ngayxb" name="ngayxb" value="<?php echo $ngayxb ?? ''; ?>">
                    <?php if(isset($errors['ngayxb'])) echo $errors['ngayxb']; ?>
                </div>
            </div>

            <div class="row mb-3">
                <label for="soluong" class="form-label col-sm-2 text-end"><strong>Số lượng</strong></label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" id="soluong" name="soluong" value="<?php echo $soluong ?? ''; ?>">
                    <?php if(isset($errors['soluong'])) echo $errors['soluong']; ?>
                </div>
            </div>

            <div class="row mb-3">
                <label for="theloai" class="form-label col-sm-2 text-end"><strong>Thể loại</strong></label>
                <div class="col-sm-9">
                    <select class="form-select" id="theloai" name="theloai">
                        <option value="">-- Chọn thể loại --</option>
                        <?php 
                            if($res_tl){
                                while($row_tl = mysqli_fetch_assoc($res_tl)){
                                    $selected = ($row_tl['ma_the_loai'] == ($ma_the_loai ?? '')) ? "selected" : "";
                                    echo "<option value='".$row_tl['ma_the_loai']."' $selected>".$row_tl['ten_the_loai']."</option>";
                                }
                            }
                        ?>
                    </select>
                    <?php if(isset($errors['theloai'])) echo $errors['theloai']; ?>
                </div>
            </div>

            <button class="btn btn-success offset-sm-2" name="save">Lưu lại</button>
        </form>
    </div>
</body>
</html>
