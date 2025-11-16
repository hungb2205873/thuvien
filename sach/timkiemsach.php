<?php 
    require_once "../config.php";
    if(!isset($_SESSION['tk'])){
        header('location: ../dangnhap.php');
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<!-- head -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUẢN LÍ SÁCH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- CSS cua tôi -->
    <link rel="stylesheet" href="style.css">
    <style>
        a{
            text-decoration:none;
        }
    </style>

</head>

<!-- body -->
<body>
    
    <div class="container">
        <a class="btn btn-primary mt-2" href="hienthisach.php">Quay trở lại</a>
        <h2 class="text-center mt-3 bg-success text-white mb-3">quản lí sách bookHub</h2>
        <ul class="list-group list-group-horizontal mb-4">
            <li class="list-group-item list-group-item-action list-group-item-light text-center"><a href="../sach/hienthisach.php">Quản lí sách</a></li>
            <li class="list-group-item list-group-item-action list-group-item-light text-center"><a href="../docgia/hienthidocgia.php">Quản lí độc giả</a></li>
            <li class="list-group-item list-group-item-action list-group-item-light text-center"><a href="../muontra/hienthimuontra.php">Quản lí mượn trả</a></li>
            <li class="list-group-item list-group-item-action list-group-item-light text-center"><a href="../docgia/hienthidocgia.php">Quản lí độc giả</a></li>
         
        </ul>
    </div>

    <div class="container">
        
        <form method="GET" action="timkiemsach.php">
            <div class="input-group mb-3" style="width:50%;margin:0 auto;">
                <input type="text" class="form-control" name="timkiem" placeholder="Nhập tên sách để tìm kiếm">
                <button class="btn btn-primary" name="submit">Tìm kiếm</button>
            </div> 
        </form>

        <table class="table table-bordered table-striped text-center">
            <thead>
                <th>STT</th>
                <th>Tên Sách</th>
                <th>Tên TG</th>
                <th>NXB</th>
                <th>Ngày XB</th>
                <th>Số Trang</th>
                <th>Tóm Tắt</th>
                <th>Thao tác</th>
            </thead>
            <tbody>
                <?php
                    if(isset($_GET['submit'])){
                        if(isset($_GET['timkiem'])){
                            $search = $_GET['timkiem'];
                        }else{
                            $search ='';
                        }
                        $sql = "SELECT * from sach where tensach like '%$search%'";
                    }else{
                        $sql = "SELECT * from sach";
                    }
                    
                    $res = mysqli_query($conn,$sql);//Thực thi câu lệnh sql
                    $index = 0;
                    if($res == true){
                        while($rows = mysqli_fetch_assoc($res)){

                            $id = $rows['id'];

                            $index++;
                            $tensach = $rows['tensach'];
                            $tentg = $rows['tentg'];
                            $nhaxuatban = $rows['nhaxuatban'];
                            $ngayxb = $rows['ngayxb'];
                            $sotrang = $rows['sotrang'];
                            $tomtat = $rows['tomtat'];
                            ?>
                            <!-- Viết code của html  -->
                            <tr>
                                <td><?php echo $index; ?></td>

                                <td><?php echo $tensach; ?></td>
                                <td><?php echo $tentg; ?></td>
                                <td><?php echo $nhaxuatban; ?></td>
                                <td><?php echo $ngayxb; ?></td>
                                <td><?php echo $sotrang; ?></td>
                                <td><?php echo $tomtat; ?></td>
                                <td><a class="btn btn-warning" href="chinhsuasach.php?id=<?php echo $id;?>">Edit</a>
                                    <a class="btn btn-danger" href="xoasach.php?id=<?php echo $id; ?>">Delete</a>                            
                                </td>
                            </tr>
                            <?php
                        }
                    }
                ?>
                
            </tbody>
        </table>

        <a href="themsach.php" class="btn btn-success">Thêm Sách</a>

    </div>
</body>
</html>