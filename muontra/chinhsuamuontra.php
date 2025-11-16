<?php    

    require_once "../config.php";

    if(isset($_GET['id'])){
        if(!isset($_SESSION['tk'])){
            header('location: ../dangnhap.php');
            die();
        }
        $id = $_GET['id'];
        $sql = "SELECT * from muontra where id = $id";
        $res = mysqli_query($conn,$sql);

        //TH id != id trong mang 
        if(mysqli_num_rows($res) == 0) {
            header('location: hienthimuontra.php');
            die();
        }

        $rows = mysqli_fetch_assoc($res);
        $id_sach1 = $rows['id_sach'];
        $id_dg1 = $rows['id_dg'];
        $ngaymuon = $rows['ngaymuon'];
        $ngaytra = $rows['ngaytra'];
        $tinhtrang = $rows['tinhtrang'];

    }
    else { //Truong hop xoa id khien id rong
        header('location: hienthimuontra.php');
        die();
    }

    if(isset($_POST['save'])){
        $id = $id_sach = $id_dg = $ngaymuon = $ngaytra = $tinhtrang = '';
        // Lay id tu URL

        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        if(isset($_POST['id_sach'])){
            $id_sach = $_POST['id_sach'];
        }
        if(isset($_POST['id_dg'])){
            $id_dg = $_POST['id_dg'];
        }
        if(isset($_POST['ngaymuon'])){
            $ngaymuon = $_POST['ngaymuon'];
        }
        if(isset($_POST['ngaytra'])){
            $ngaytra = $_POST['ngaytra'];
        }
        if(isset($_POST['tinhtrang'])){
            $tinhtrang = $_POST['tinhtrang'];
        }


        //Fix lỗi SQL Injection
        $id_sach = str_replace('\'','\\\'',$id_sach);
        $id_dg = str_replace('\'','\\\'',$id_dg);
        $ngaymuon = str_replace('\'','\\\'',$ngaymuon);
        $ngaytra = str_replace('\'','\\\'',$ngaytra);
        $tinhtrang = str_replace('\'','\\\'',$tinhtrang);

        $sql = "SELECT * from muontra";
        $res = mysqli_query($conn,$sql);

        $errors = array();
        if($id_sach == ''){
            $errors['id_sach'] = "<div class='text-danger'>Bạn chưa nhập id sách.</div>";
        }
        if($id_dg == ''){
            $errors['id_dg'] = "<div class='text-danger'>Bạn chưa nhập id độc giả.</div>";
        }
        if($ngaymuon == ''){
            $errors['ngaymuon'] = "<div class='text-danger'>Bạn chưa nhập ngày mượn.</div>";
        }
        if($ngaytra == ''){
            $errors['ngaytra'] = "<div class='text-danger'>Bạn chưa nhập ngày trả.</div>";
        }
        if($tinhtrang == ''){
            $errors['tinhtrang'] = "<div class='text-danger'>Bạn chưa nhập tình trạng sách.</div>";
        }

        if(!$errors){
            $sql = "CALL chinhsuamuontra('$id_sach','$id_dg','$ngaymuon','$ngaytra','$tinhtrang','$id')";
            $res = mysqli_query($conn,$sql);
            if($res == true){
                $_SESSION['chinhsuamuontra1'] = "<div class='text-success' style='font-size:20px'><strong>Chỉnh sửa thẻ mượn trả thành công</strong></div>";
                header('location: hienthimuontra.php');
            }
            else {
                $_SESSION['chinhsuamuontra']="<div class='text-danger text-center' style='font-size:20px'><strong>Chỉnh sửa thẻ mượn trả thất bại</strong></div>";
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
        <a href="hienthimuontra.php" class="btn btn-primary">Quay trở lại</a>
        <h2 class="text-center bg-success text-white mt-4 mb-4">CHỈNH SỬA MƯỢN TRẢ</h2>

        <?php 
            if(isset($_SESSION['chinhsuamuontra1'])){
                echo $_SESSION['chinhsuamuontra1'];
                unset($_SESSION['chinhsuamuontra1']);
            }
        ?>

        <form  method="POST">
        <div class="row mb-5">
                <label class="form-label col-sm-3 text-end "><strong>Chọn sách trong danh sách</strong></label>
                <div class="col-sm-9">
                    <select name="id_sach">
                        <option value="">Chọn sách</option>
                        <?php 
                            $sql = "SELECT * from sach";
                            $res = mysqli_query($conn,$sql);
                            $count = mysqli_num_rows($res);
                            if($count>0){
                                while($rows = mysqli_fetch_assoc($res)){
                                    $id_sach = $rows['id'];
                                    $tensach = $rows['tensach'];
                                    
                                    ?>
                                    <option  value="<?php echo $id_sach; ?>" <?php if($id_sach == $id_sach1){echo 'selected';} ?>><?php echo $tensach; ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-5">
                <label class="form-label col-sm-3 text-end "><strong>Chọn độc giả trong danh sách</strong></label>
                <div class="col-sm-9">
                    <select name="id_dg">
                        <option value="">Chọn độc giả</option>
                        <?php 
                            $sql = "SELECT * from docgia";
                            $res = mysqli_query($conn,$sql);
                            $count = mysqli_num_rows($res);
                            if($count>0){
                                while($rows = mysqli_fetch_assoc($res)){
                                    $id_dg = $rows['id'];
                                    $tendg = $rows['tendg'];
                                    
                                    ?>
                                    <option  value="<?php echo $id_dg; ?>" <?php if($id_dg == $id_dg1){echo 'selected';} ?>><?php echo $tendg; ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-5">
                <label for="ngaymuon" class="form-label col-sm-2 text-end "><strong>Nhập ngày mượn</strong></label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" id="ngaymuon" placeholder="Nhập ngày mượn" name="ngaymuon" value="<?php if(isset($ngaymuon)) {echo $ngaymuon;} ?>">
                    <?php 
                        if(isset($errors['ngaymuon'])){
                            echo $errors['ngaymuon'];
                        }
                    ?>
                </div>
            </div>
            
            <div class="row mb-5">
                <label for="ngaytra" class="form-label col-sm-2 text-end "><strong>Nhập ngày trả</strong></label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" id="ngaytra" placeholder="Nhập ngày trả" name="ngaytra" value="<?php if(isset($ngaytra)) {echo $ngaytra;} ?>">
                    <?php 
                        if(isset($errors['ngaytra'])){
                            echo $errors['ngaytra'];
                        }
                    ?>
                </div>
            </div>
            
            <div class="row mb-5">
                <label for="active" class="form-label col-sm-2 text-end "><strong>Chọn tình trạng</strong></label>
                <div class="col-sm-9">
                    <span class="mx-3"><input type="radio" name="tinhtrang" value="Đã trả" <?php if(isset($active) && $active == 'Đã trả'){echo "checked='checked'";}?>>Trả</span>
                    <span class="mx-3"><input type="radio" name="tinhtrang" value="Trả muộn" <?php if(isset($active) && $active == 'Trả muộn'){echo "checked='checked'";}?>> Trả muộn</span>
                    <?php 
                        if(isset($errors['tinhtrang'])){
                            echo $errors['tinhtrang'];
                        }
                    ?>
                </div>
            </div>

            <button class="btn btn-success offset-sm-2" name="save">Lưu lại</button>

        </form>
    </div>
</body>
</html>