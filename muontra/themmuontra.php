<?php 
    require_once "../config.php";
    if(!isset($_SESSION['tk'])){
        header('location: ../dangnhap.php');
        die();
    }

    if(isset($_POST['save'])){
        $id_sach    = $_POST['id_sach'] ?? '';
        $id_dg      = $_POST['id_dg'] ?? '';
        $ngaymuon   = $_POST['ngaymuon'] ?? '';
        $ngaytra    = $_POST['ngaytra'] ?? '';
        $trangthai  = $_POST['trangthai'] ?? '';

        $errors = array();
        if($id_sach == '')   $errors['id_sach']   = "<div class='text-danger'>Bạn chưa chọn sách.</div>";
        if($id_dg == '')     $errors['id_dg']     = "<div class='text-danger'>Bạn chưa chọn độc giả.</div>";
        if($ngaymuon == '')  $errors['ngaymuon']  = "<div class='text-danger'>Bạn chưa nhập ngày mượn.</div>";
        if($ngaytra == '')   $errors['ngaytra']   = "<div class='text-danger'>Bạn chưa nhập ngày trả.</div>";
        if($trangthai == '') $errors['trangthai'] = "<div class='text-danger'>Bạn chưa chọn trạng thái.</div>";

        if(!$errors){
            // Kiểm tra số lượng sách còn lại
            $sql_check = "SELECT so_luong FROM sach WHERE ma_sach = '$id_sach'";
            $res_check = mysqli_query($conn,$sql_check);
            $row_check = mysqli_fetch_assoc($res_check);

            if($row_check['so_luong'] <= 0){
                $_SESSION['themmuontra'] = "<div class='text-danger'><strong>Sách này đã hết, không thể mượn</strong></div>";
                header('location: themmuontra.php');
                exit;
            }

            // Thêm phiếu mượn
            $sql1 = "INSERT INTO phieu_muon(ma_doc_gia, ngay_muon, ngay_tra, trang_thai)
                     VALUES('$id_dg','$ngaymuon','$ngaytra','$trangthai')";
            $res1 = mysqli_query($conn,$sql1);

            if($res1){
                $last_id = mysqli_insert_id($conn); // lấy id phiếu vừa thêm

                // Thêm chi tiết phiếu mượn
                $sql2 = "INSERT INTO chi_tiet_phieu_muon(ma_phieu_muon, ma_sach)
                         VALUES('$last_id','$id_sach')";
                $res2 = mysqli_query($conn,$sql2);

                // Trừ số lượng sách
                $sql3 = "UPDATE sach SET so_luong = so_luong - 1 WHERE ma_sach = '$id_sach'";
                $res3 = mysqli_query($conn,$sql3);

                if($res2 && $res3){
                    $_SESSION['themmuontra1'] = "<div class='text-success'><strong>Thêm phiếu mượn thành công</strong></div>";
                    header('location: hienthimuontra.php');
                    exit;
                }
            }
            $_SESSION['themmuontra'] = "<div class='text-danger text-center'><strong>Thêm phiếu mượn thất bại</strong></div>";
        }
    }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm phiếu mượn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-3">
        <a href="hienthimuontra.php" class="btn btn-primary">Quay trở lại</a>
        <h2 class="text-center mt-3 text-white mb-3" style="background: linear-gradient(to right, #6EC6FF, #6A1B9A);">Thêm phiếu mượn</h2>

        <form method="POST">
            <!-- Chọn sách -->
            <div class="row mb-3">
                <label class="form-label col-sm-2 text-end"><strong>Sách</strong></label>
                <div class="col-sm-10">
                    <select name="id_sach" class="form-select">
                        <option value="">Chọn sách</option>
                        <?php 
                            $sql = "SELECT ma_sach, ten_sach FROM sach";
                            $res = mysqli_query($conn,$sql);
                            while($row = mysqli_fetch_assoc($res)){
                                echo "<option value='".$row['ma_sach']."'>".$row['ten_sach']."</option>";
                            }
                        ?>
                    </select>
                    <?php if(isset($errors['id_sach'])) echo $errors['id_sach']; ?>
                </div>
            </div>

            <!-- Chọn độc giả -->
            <div class="row mb-3">
                <label class="form-label col-sm-2 text-end"><strong>Độc giả</strong></label>
                <div class="col-sm-10">
                    <select name="id_dg" class="form-select">
                        <option value="">Chọn độc giả</option>
                        <?php 
                            $sql = "SELECT ma_doc_gia, ten_doc_gia FROM doc_gia";
                            $res = mysqli_query($conn,$sql);
                            while($row = mysqli_fetch_assoc($res)){
                                echo "<option value='".$row['ma_doc_gia']."'>".$row['ten_doc_gia']."</option>";
                            }
                        ?>
                    </select>
                    <?php if(isset($errors['id_dg'])) echo $errors['id_dg']; ?>
                </div>
            </div>

            <!-- Ngày mượn -->
            <div class="row mb-3">
                <label for="ngaymuon" class="form-label col-sm-2 text-end"><strong>Ngày mượn</strong></label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="ngaymuon" name="ngaymuon">
                    <?php if(isset($errors['ngaymuon'])) echo $errors['ngaymuon']; ?>
                </div>
            </div>

            <!-- Ngày trả -->
            <div class="row mb-3">
                <label for="ngaytra" class="form-label col-sm-2 text-end"><strong>Ngày trả</strong></label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="ngaytra" name="ngaytra">
                    <?php if(isset($errors['ngaytra'])) echo $errors['ngaytra']; ?>
                </div>
            </div>

            <!-- Trạng thái -->
            <div class="row mb-3">
                <label class="form-label col-sm-2 text-end"><strong>Trạng thái</strong></label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="trangthai" value="Đang mượn">
                        <label class="form-check-label">Đang mượn</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="trangthai" value="Đã trả">
                        <label class="form-check-label">Đã trả</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="trangthai" value="Trả muộn">
                        <label class="form-check-label">Trả muộn</label>
                    </div>
                    <?php if(isset($errors['trangthai'])) echo $errors['trangthai']; ?>
                </div>
            </div>

            <!-- Nút lưu -->
            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <button class="btn btn-success" name="save">Lưu lại</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
