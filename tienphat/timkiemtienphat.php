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
    <title>TÌM KIẾM TIỀN PHẠT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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
    <div class="container">
        <a class="btn btn-primary mt-2" href="../dangxuat.php">Đăng xuất</a>
        <h2 class="text-center mt-3 bg-success text-white mb-3">Kết Quả Tìm Kiếm Tiền Phạt</h2>
    </div>

    <div class="container mt-4">
        <form method="GET" action="timkiemtienphat.php" class="input-group mb-3">
            <input type="text" class="form-control" name="timkiem" placeholder="Nhập tên độc giả">
            <button class="btn btn-primary" name="submit">Tìm kiếm</button>
        </form>
        <a href="hienthitienphat.php" class="btn btn-secondary mb-3">Quay lại</a>

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
                    <th>Tiền Phạt</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(isset($_GET['submit']) && isset($_GET['timkiem'])){
                        $search = mysqli_real_escape_string($conn, $_GET['timkiem']);
                        $sql = "SELECT mt.id, mt.id_sach, mt.id_dg, mt.ngaymuon, mt.ngaytra, mt.tinhtrang, 
                                       dg.tendg, s.tensach, s.gia
                                FROM muontra mt
                                JOIN docgia dg ON mt.id_dg = dg.id
                                JOIN sach s ON mt.id_sach = s.id
                                WHERE mt.tinhtrang = 'Chưa trả' AND dg.tendg LIKE '%$search%'
                                ORDER BY mt.ngaytra ASC";
                        
                        $res = mysqli_query($conn, $sql);
                        $index = 0;
                        $tongtienphat = 0;
                        
                        if($res && mysqli_num_rows($res) > 0){
                            while($rows = mysqli_fetch_assoc($res)){
                                $index++;
                                $tendg = $rows['tendg'];
                                $tensach = $rows['tensach'];
                                $ngaymuon = $rows['ngaymuon'];
                                $ngaytra = $rows['ngaytra'];
                                $gia = $rows['gia'];
                                
                                $today = date('Y-m-d');
                                $ngaytra_time = strtotime($ngaytra);
                                $today_time = strtotime($today);
                                $soNgayQuaHan = max(0, ceil(($today_time - $ngaytra_time) / (60 * 60 * 24)));
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
                        } else {
                            echo '<tr><td colspan="9" class="text-danger">Không tìm thấy độc giả hoặc độc giả không có sách chưa trả</td></tr>';
                        }
                    }
                ?>
            </tbody>
        </table>

        <?php if(isset($_GET['submit']) && isset($_GET['timkiem']) && $index > 0): ?>
        <div class="alert alert-warning mt-3">
            <h5>Tổng tiền phạt: <strong><?php echo number_format($tongtienphat, 0, ',', '.'); ?>đ</strong></h5>
        </div>
        <?php endif; ?>

    </div>
</body>
</html>
