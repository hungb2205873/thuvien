<?php    
    require_once "../config.php";

    if(!isset($_SESSION['tk'])){
        header('location: ../dangnhap.php');
        die();
    }

    if(isset($_GET['id'])){
        $id = (int)$_GET['id'];
        // Join để lấy cả thông tin sách và độc giả
        $sql = "SELECT pm.ma_phieu_muon, pm.ma_doc_gia, pm.ngay_muon, pm.ngay_tra, pm.trang_thai,
                       ct.ma_sach
                FROM phieu_muon pm
                JOIN chi_tiet_phieu_muon ct ON pm.ma_phieu_muon = ct.ma_phieu_muon
                WHERE pm.ma_phieu_muon = $id";
        $res = mysqli_query($conn,$sql);

        if(mysqli_num_rows($res) == 0) {
            header('location: hienthimuontra.php');
            die();
        }

        $rows = mysqli_fetch_assoc($res);
        $id_sach1   = $rows['ma_sach'];
        $id_dg1     = $rows['ma_doc_gia'];
        $ngay_muon  = $rows['ngay_muon'];
        $ngay_tra   = $rows['ngay_tra'];
        $trang_thai = $rows['trang_thai'];
    } else {
        header('location: hienthimuontra.php');
        die();
    }

    if(isset($_POST['save'])){
        $id         = (int)$_GET['id'];
        $id_sach    = $_POST['id_sach'] ?? '';
        $id_dg      = $_POST['id_dg'] ?? '';
        $ngay_muon  = $_POST['ngay_muon'] ?? '';
        $ngay_tra   = $_POST['ngay_tra'] ?? '';
        $trang_thai = $_POST['trang_thai'] ?? '';

        $errors = array();
        if($id_sach == '')   $errors['id_sach']   = "<div class='text-danger'>Bạn chưa chọn sách.</div>";
        if($id_dg == '')     $errors['id_dg']     = "<div class='text-danger'>Bạn chưa chọn độc giả.</div>";
        if($ngay_muon == '') $errors['ngay_muon'] = "<div class='text-danger'>Bạn chưa nhập ngày mượn.</div>";
        if($ngay_tra == '')  $errors['ngay_tra']  = "<div class='text-danger'>Bạn chưa nhập ngày trả.</div>";
        if($trang_thai == '')$errors['trang_thai']= "<div class='text-danger'>Bạn chưa chọn trạng thái.</div>";

        if(!$errors){
            // Cập nhật bảng phieu_muon
            $sql1 = "UPDATE phieu_muon 
                     SET ma_doc_gia='$id_dg', ngay_muon='$ngay_muon', ngay_tra='$ngay_tra', trang_thai='$trang_thai'
                     WHERE ma_phieu_muon=$id";
            $res1 = mysqli_query($conn,$sql1);

            // Cập nhật bảng chi_tiet_phieu_muon
            $sql2 = "UPDATE chi_tiet_phieu_muon 
                     SET ma_sach='$id_sach'
                     WHERE ma_phieu_muon=$id";
            $res2 = mysqli_query($conn,$sql2);

            if($res1 && $res2){
                $_SESSION['chinhsuaphieu1'] = "<div class='text-success' style='font-size:20px'><strong>Chỉnh sửa phiếu mượn thành công</strong></div>";
                header('location: hienthimuontra.php');
                exit;
            } else {
                $_SESSION['chinhsuaphieu']="<div class='text-danger text-center' style='font-size:20px'><strong>Chỉnh sửa phiếu mượn thất bại</strong></div>";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>CHỈNH SỬA PHIẾU MƯỢN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-3">
        <a href="hienthimuontra.php" class="btn btn-primary">Quay trở lại</a>
        <h2 class="text-center bg-success text-white mt-4 mb-4">CHỈNH SỬA PHIẾU MƯỢN</h2>

        <?php 
            if(isset($_SESSION['chinhsuaphieu1'])){
                echo $_SESSION['chinhsuaphieu1'];
                unset($_SESSION['chinhsuaphieu1']);
            }
        ?>

        <form method="POST">
    <!-- Chọn sách -->
    <div class="row mb-3">
        <label class="form-label col-sm-2 text-end"><strong>Tên sách</strong></label>
        <div class="col-sm-10">
            <select name="id_sach" class="form-select">
                <option value="">Chọn sách</option>
                <?php 
                    $sql = "SELECT ma_sach, ten_sach FROM sach";
                    $res = mysqli_query($conn,$sql);
                    while($row = mysqli_fetch_assoc($res)){
                        $selected = ($row['ma_sach'] == $id_sach1) ? "selected" : "";
                        echo "<option value='".$row['ma_sach']."' $selected>".$row['ten_sach']."</option>";
                    }
                ?>
            </select>
            <?php if(isset($errors['id_sach'])) echo $errors['id_sach']; ?>
        </div>
    </div>

    <!-- Chọn độc giả -->
    <div class="row mb-3">
        <label class="form-label col-sm-2 text-end"><strong>Tên độc giả</strong></label>
        <div class="col-sm-10">
            <select name="id_dg" class="form-select">
                <option value="">Chọn độc giả</option>
                <?php 
                    $sql = "SELECT ma_doc_gia, ten_doc_gia FROM doc_gia";
                    $res = mysqli_query($conn,$sql);
                    while($row = mysqli_fetch_assoc($res)){
                        $selected = ($row['ma_doc_gia'] == $id_dg1) ? "selected" : "";
                        echo "<option value='".$row['ma_doc_gia']."' $selected>".$row['ten_doc_gia']."</option>";
                    }
                ?>
            </select>
            <?php if(isset($errors['id_dg'])) echo $errors['id_dg']; ?>
        </div>
    </div>

    <!-- Ngày mượn -->
    <div class="row mb-3">
        <label for="ngay_muon" class="form-label col-sm-2 text-end"><strong>Ngày mượn</strong></label>
        <div class="col-sm-10">
            <input type="date" class="form-control" id="ngay_muon" name="ngay_muon" value="<?php echo $ngay_muon; ?>">
            <?php if(isset($errors['ngay_muon'])) echo $errors['ngay_muon']; ?>
        </div>
    </div>

    <!-- Ngày trả -->
    <div class="row mb-3">
        <label for="ngay_tra" class="form-label col-sm-2 text-end"><strong>Ngày trả</strong></label>
        <div class="col-sm-10">
            <input type="date" class="form-control" id="ngay_tra" name="ngay_tra" value="<?php echo $ngay_tra; ?>">
            <?php if(isset($errors['ngay_tra'])) echo $errors['ngay_tra']; ?>
        </div>
    </div>

    <!-- Trạng thái -->
    <div class="row mb-3">
        <label class="form-label col-sm-2 text-end"><strong>Trạng thái</strong></label>
        <div class="col-sm-10">
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" name="trang_thai" value="Đang mượn" <?php if($trang_thai == 'Đang mượn') echo "checked"; ?>>
                <label class="form-check-label">Đang mượn</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" name="trang_thai" value="Đã trả" <?php if($trang_thai == 'Đã trả') echo "checked"; ?>>
                <label class="form-check-label">Đã trả</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" name="trang_thai" value="Trả muộn" <?php if($trang_thai == 'Trả muộn') echo "checked"; ?>>
                <label class="form-check-label">Trả muộn</label>
            </div>
            <?php if(isset($errors['trang_thai'])) echo $errors['trang_thai']; ?>
        </div>
    </div>

    <!-- Nút lưu -->
    <div class="row mb-3">
        <div class="col-sm-10 offset-sm-2">
            <button class="btn btn-success" name="save">Lưu lại</button>
        </div>
    </div>
</form>
