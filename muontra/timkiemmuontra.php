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
        <a class="btn btn-primary mt-2" href="hienthimuontra.php">Quay trở lại</a>
        <h2 class="text-center mt-3 bg-success text-white mb-3">quản lí sách bookHub</h2>
        <ul class="list-group list-group-horizontal mb-4">
            <li class="list-group-item list-group-item-action list-group-item-light text-center"><a href="../sach/hienthisach.php">Quản lí sách</a></li>
            <li class="list-group-item list-group-item-action list-group-item-light text-center"><a href="../docgia/hienthidocgia.php">Quản lí độc giả</a></li>
            <li class="list-group-item list-group-item-action list-group-item-light text-center"><a href="../muontra/hienthimuontra.php">Quản lí mượn trả</a></li>
        </ul>
    </div>

    <div class="container">
        
        <form method="GET" action="timkiemmuontra.php">
            <div class="input-group mb-3" style="width:50%;margin:0 auto;">
                <input type="text" class="form-control" name="timkiem" placeholder="Tìm kiếm sách theo tình trạng">
                <button class="btn btn-primary" name="submit">Tìm kiếm</button>
            </div> 
        </form>

        <table class="table table-bordered table-striped text-center">
            <thead>
                <th>STT</th>
                <th>Tên sách</th>
                <th>Tên Độc Giả</th>
                <th>Ngày mượn</th>
                <th>Ngày trả</th>
                <th>Tình Trạng</th>
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
                        $sql = "SELECT * from muontra where tinhtrang like '%$search%'";
                    }else{
                        $sql = "SELECT * from muontra";
                    }
                    
                    $res = mysqli_query($conn,$sql);//Thực thi câu lệnh sql
                    $index = 0;
                    if($res == true){
                        while($rows = mysqli_fetch_assoc($res)){

                            $id = $rows['id'];

                            $index++;
                            $id_sach = $rows['id_sach'];
                            $id_dg = $rows['id_dg'];
                            $ngaymuon = $rows['ngaymuon'];
                            $ngaytra = $rows['ngaytra'];
                            $tinhtrang = $rows['tinhtrang'];
                            ?>
                            <!-- Viết code của html  -->
                            <tr>
                                <td><?php echo $index; ?></td>

                                <td>
                                    <?php
                                        $sql1 = "SELECT * FROM sach where id = $id_sach";
                                        $res1 = mysqli_query($conn,$sql1);
                                        while($rows1 = mysqli_fetch_assoc($res1)){
                                            $tensach = $rows1['tensach'];
                                            echo $tensach;
                                        }
                                        
                                    ?>
                                </td>

                                <td>
                                    <?php
                                        $sql2 = "SELECT * FROM docgia where id = $id_dg";
                                        $res2 = mysqli_query($conn,$sql2);
                                        while($rows2 = mysqli_fetch_assoc($res2)){
                                            $tendg = $rows2['tendg'];
                                            echo $tendg;
                                        }
                                        
                                    ?>
                                </td>

                                <td><?php echo $ngaymuon; ?></td>
                                <td><?php echo $ngaytra; ?></td>
                                <td><?php echo $tinhtrang; ?></td>
                                <td><a class="btn btn-warning" href="chinhsuamuontra.php?id=<?php echo $id;?>">Edit</a>
                                    <a class="btn btn-danger" href="xoabanmuon.php?id=<?php echo $id; ?>">Delete</a>                            
                                </td>
                            </tr>
                            <?php
                        }
                    }
                ?>
                
            </tbody>
        </table>

        <a href="themmuontra.php" class="btn btn-success">Thêm Mượn Trả</a>

    </div>
</body>
</html>