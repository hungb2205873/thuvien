<?php 
    require_once "../config.php";
    if(!isset($_SESSION['tk'])){
        header('location: ../dangnhap.php');
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <nav class="navbar navbar-expand-lg navbar-light shadow-sm sticky-top" style="background: linear-gradient(to right, #6EC6FF, #6A1B9A);">
    <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="../index.php">
            <span class="text-gradient">📚 BookHub</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li>
                    <a class="btn btn-primary mt-2" href="../dangxuat.php">Đăng xuất</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUẢN LÍ THƯ VIỆN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        a{ text-decoration:none; }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center mt-3 text-white mb-3" style="background: linear-gradient(to right, #6EC6FF, #6A1B9A);">Quản lí độc giả BookHub</h2>
        <ul class="list-group list-group-horizontal mb-4">
            <li class="list-group-item text-center"><a href="../sach/hienthisach.php">Quản lí sách</a></li>
            <li class="list-group-item text-center"><a href="../docgia/hienthidocgia.php">Quản lí độc giả</a></li>
            <li class="list-group-item text-center"><a href="../muontra/hienthimuontra.php">Quản lí mượn trả</a></li>
            <li class="list-group-item text-center"><a href="../tienphat/hienthitienphat.php">Quản lí tiền phạt</a></li>
        </ul>
    </div>

    <div class="container">
        <form method="GET" action="timkiemdocgia.php">
            <div class="input-group mb-3" style="width:50%;margin:0 auto;">
                <input type="text" class="form-control" name="timkiem" placeholder="Nhập tên độc giả để tìm kiếm">
                <button class="btn btn-primary" name="submit">Tìm kiếm</button>
            </div> 
        </form>

        <table class="table table-bordered table-striped text-center">
            <thead>
                <th>STT</th>
                <th>Tên Độc Giả</th>
                <th>Ngày Sinh</th>
                <th>Số Điện Thoại</th>
                <th>Email</th>
                <th>Thao tác</th>
            </thead>
            <tbody>
                <?php
                    if(isset($_GET['submit'])){
                        $search = isset($_GET['timkiem']) ? $_GET['timkiem'] : '';
                        $sql = "SELECT * FROM doc_gia WHERE ten_doc_gia LIKE '%$search%'";
                    }else{
                        $sql = "SELECT * FROM doc_gia";
                    }
                    
                    $res = mysqli_query($conn,$sql);
                    $index = 0;
                    if($res){
                        while($rows = mysqli_fetch_assoc($res)){
                            $index++;
                            $id = $rows['ma_doc_gia'];
                            $ten = $rows['ten_doc_gia'];
                            $ngaysinh = $rows['ngay_sinh'];
                            $sdt = $rows['so_dien_thoai'];
                            $email = $rows['email'];
                            ?>
                            <tr>
                                <td><?php echo $index; ?></td>
                                <td><?php echo $ten; ?></td>
                                <td><?php echo $ngaysinh; ?></td>
                                <td><?php echo $sdt; ?></td>
                                <td><?php echo $email; ?></td>
                                <td>
                                    <a class="btn btn-warning" href="chinhsuadocgia.php?id=<?php echo $id;?>">Edit</a>
                                    <a class="btn btn-danger" href="xoadocgia.php?id=<?php echo $id; ?>">Delete</a>                            
                                </td>
                            </tr>
                            <?php
                        }
                    }
                ?>
            </tbody>
        </table>

        <a href="themdocgia.php" class="btn btn-success">Thêm Độc Giả</a>
    </div>
</body>
</html>
