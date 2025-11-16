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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUẢN LÍ TIỀN PHẠT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../muontra/style.css">
    <style>
        a{
            text-decoration:none;
        }
        .penalty-badge {
            font-size: 16px;
            font-weight: bold;
            padding: 8px 12px;
        }
        .no-penalty {
            background-color: #28a745;
            color: white;
        }
        .has-penalty {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>

<body>
   <nav class="navbar navbar-expand-lg navbar-light shadow-sm sticky-top" style="background: linear-gradient(to right, #6EC6FF, #6A1B9A);">

    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php">
            <span class="text-gradient">📚 BookHub</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                
                   
                </li>
                    <a class="btn btn-primary mt-2" href="../dangxuat.php">Đăng xuất</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
    <div class="container">
        <h2 class="text-center mt-3 text-white mb-3" style="background: linear-gradient(to right, #6EC6FF, #6A1B9A);">quản lí sách bookHub</h2>
        <ul class="list-group list-group-horizontal mb-4">
            <li class="list-group-item list-group-item-action list-group-item-light text-center"><a href="../sach/hienthisach.php">Quản lí sách</a></li>
            <li class="list-group-item list-group-item-action list-group-item-light text-center"><a href="../docgia/hienthidocgia.php">Quản lí độc giả</a></li>
            <li class="list-group-item list-group-item-action list-group-item-light text-center"><a href="../muontra/hienthimuontra.php">Quản lí mượn trả</a></li>
            <li class="list-group-item list-group-item-action list-group-item-light text-center"><a href="hienthitienphat.php">Quản lí tiền phạt</a></li>
        </ul>
    </div>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h4>Tìm kiếm theo tên độc giả</h4>
                <form method="GET" action="timkiemtienphat.php" class="input-group">
                    <input type="text" class="form-control" name="timkiem" placeholder="Nhập tên độc giả">
                    <button class="btn btn-primary" name="submit">Tìm kiếm</button>
                </form>
            </div>
            <div class="col-md-6">
                <a href="xuatbaocaotienphat.php" class="btn btn-info" style="margin-top: 32px;">Xuất báo cáo tiền phạt</a>
            </div>
        </div>

        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Tên Độc Giả</th>
                    <th>Tên Sách</th>
                    <th>Ngày Mượn</th>
                    <th>Ngày Trả Hạn</th>
                    <th>Trạng Thái</th>
                    <th>Giá Sách</th>
                    <th>Số Ngày Quá Hạn</th>
                    <th>Tiền Phạt (1000đ/ngày)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT mt.id, mt.id_sach, mt.id_dg, mt.ngaymuon, mt.ngaytra, mt.tinhtrang, 
                                   dg.tendg, s.tensach, s.gia
                            FROM muontra mt
                            JOIN docgia dg ON mt.id_dg = dg.id
                            JOIN sach s ON mt.id_sach = s.id
                            WHERE mt.tinhtrang = 'Chưa trả'
                            ORDER BY mt.ngaytra ASC";
                    
                    $res = mysqli_query($conn, $sql);
                    $index = 0;
                    $tongtienphat = 0;
                    
                    if($res == true){
                        while($rows = mysqli_fetch_assoc($res)){
                            $index++;
                            $id = $rows['id'];
                            $tendg = $rows['tendg'];
                            $tensach = $rows['tensach'];
                            $ngaymuon = $rows['ngaymuon'];
                            $ngaytra = $rows['ngaytra'];
                            $tinhtrang = $rows['tinhtrang'];
                            $gia = $rows['gia'];
                            
                            // Tính số ngày quá hạn
                            $today = date('Y-m-d');
                            $ngaytra_time = strtotime($ngaytra);
                            $today_time = strtotime($today);
                            $soNgayQuaHan = max(0, ceil(($today_time - $ngaytra_time) / (60 * 60 * 24)));
                            
                            // Tính tiền phạt (1000đ/ngày)
                            $tienphat = $soNgayQuaHan * 1000;
                            $tongtienphat += $tienphat;
                            
                            $badgeClass = ($tienphat > 0) ? 'has-penalty' : 'no-penalty';
                            $badgeText = ($tienphat > 0) ? 'Nợ tiền' : 'Không nợ';
                            ?>
                            <tr>
                                <td><?php echo $index; ?></td>
                                <td><?php echo $tendg; ?></td>
                                <td><?php echo $tensach; ?></td>
                                <td><?php echo $ngaymuon; ?></td>
                                <td><?php echo $ngaytra; ?></td>
                                <td><span class="badge penalty-badge <?php echo $badgeClass; ?>"><?php echo $badgeText; ?></span></td>
                                <td><?php echo number_format($gia, 0, ',', '.'); ?>đ</td>
                                <td><?php echo $soNgayQuaHan; ?> ngày</td>
                                <td><strong><?php echo number_format($tienphat, 0, ',', '.'); ?>đ</strong></td>
                            </tr>
                            <?php
                        }
                    }
                ?>
            </tbody>
        </table>

        <div class="alert alert-warning mt-3">
            <h5>Tổng tiền phạt chưa thu: <strong><?php echo number_format($tongtienphat, 0, ',', '.'); ?>đ</strong></h5>
        </div>

    </div>
</body>
</html>
