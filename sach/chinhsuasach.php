<?php    
    require_once "../config.php";

    if(isset($_GET['id'])){
        if(!isset($_SESSION['tk'])){
            header('location: ../dangnhap.php');
            die();
        }
        $id = $_GET['id'];
        // Lấy dữ liệu sách theo ma_sach
        $sql = "SELECT * FROM sach WHERE ma_sach = $id";
        $res = mysqli_query($conn,$sql);

        if(mysqli_num_rows($res) == 0) {
            header('location: hienthisach.php');
            die();
        }

        $rows = mysqli_fetch_assoc($res);
        $tensach    = $rows['ten_sach'];
        $nhaxuatban = $rows['nha_xuat_ban'];
        $namxb      = $rows['nam_xuat_ban'];
        $soluong    = $rows['so_luong'];
        $tomtat     = isset($rows['tom_tat']) ? $rows['tom_tat'] : '';
    }
    else {
        header('location: hienthisach.php');
        die();
    }

    if(isset($_POST['save'])){
        $id         = $_GET['id'];
        $tensach    = $_POST['tensach'] ?? '';
        $nhaxuatban = $_POST['nhaxuatban'] ?? '';
        $namxb      = $_POST['namxb'] ?? '';
        $soluong    = $_POST['soluong'] ?? '';
        $tomtat     = $_POST['tomtat'] ?? '';

        // In hoa tên sách
        $tensach = strtoupper($tensach);

        $errors = array();
        if($tensach == '')    $errors['tensach']    = "<div class='text-danger'>Bạn chưa nhập tên sách.</div>";
        if($nhaxuatban == '') $errors['nhaxuatban'] = "<div class='text-danger'>Bạn chưa nhập nhà xuất bản.</div>";
        if($namxb == '')      $errors['namxb']      = "<div class='text-danger'>Bạn chưa nhập năm xuất bản.</div>";
        if($soluong == '')    $errors['soluong']    = "<div class='text-danger'>Bạn chưa nhập số lượng sách.</div>";
        if($tomtat == '')     $errors['tomtat']     = "<div class='text-danger'>Bạn chưa nhập bản tóm tắt.</div>";

        if(!$errors){
            // Gọi procedure CapNhat trong qlthuvien.sql
       $sql = "CALL CapNhat('$id','$tensach','$tentg','$nhaxuatban','$namxb','$soluong','$tomtat')";

            $res = mysqli_query($conn,$sql);
            if($res){
                $_SESSION['chinhsuasach1'] = "<div class='text-success' style='font-size:20px'><strong>Chỉnh sửa sách thành công</strong></div>";
                header('location: hienthisach.php');
                exit;
            } else {
                $_SESSION['chinhsuasach']="<div class='text-danger text-center' style='font-size:20px'><strong>Chỉnh sửa sách thất bại</strong></div>";
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
        <h2 class="text-center bg-success text-white mt-4 mb-4">CHỈNH SỬA SÁCH</h2>

        <?php 
            if(isset($_SESSION['chinhsuasach1'])){
                echo $_SESSION['chinhsuasach1'];
                unset($_SESSION['chinhsuasach1']);
            }
            if(isset($_SESSION['chinhsuasach'])){
                echo $_SESSION['chinhsuasach'];
                unset($_SESSION['chinhsuasach']);
            }
        ?>

        <form method="POST">
            <div class="row mb-3">
                <label for="tensach" class="form-label col-sm-2 text-end"><strong>Tên sách</strong></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="tensach" name="tensach" value="<?php echo $tensach; ?>">
                    <?php if(isset($errors['tensach'])) echo $errors['tensach']; ?>
                </div>
            </div>

            <div class="row mb-3">
                <label for="nhaxuatban" class="form-label col-sm-2 text-end"><strong>Nhà xuất bản</strong></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nhaxuatban" name="nhaxuatban" value="<?php echo $nhaxuatban; ?>">
                    <?php if(isset($errors['nhaxuatban'])) echo $errors['nhaxuatban']; ?>
                </div>
            </div>

            <div class="row mb-3">
                <label for="namxb" class="form-label col-sm-2 text-end"><strong>Năm xuất bản</strong></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="namxb" name="namxb" value="<?php echo $namxb; ?>">
                    <?php if(isset($errors['namxb'])) echo $errors['namxb']; ?>
                </div>
            </div>

            <div class="row mb-3">
                <label for="soluong" class="form-label col-sm-2 text-end"><strong>Số lượng</strong></label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" id="soluong" name="soluong" value="<?php echo $soluong; ?>">
                    <?php if(isset($errors['soluong'])) echo $errors['soluong']; ?>
                </div>
            </div>

            <div class="row mb-3">
                <label for="tomtat" class="form-label col-sm-2 text-end"><strong>Tóm tắt</strong></label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="tomtat" name="tomtat"><?php echo $tomtat; ?></textarea>
                    <?php if(isset($errors['tomtat'])) echo $errors['tomtat']; ?>
                </div>
            </div>

            <button class="btn btn-success offset-sm-2" name="save">Lưu lại</button>
        </form>
    </div>
</body>
</html>
