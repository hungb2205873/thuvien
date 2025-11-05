<?php
include "db.php"; // file kết nối MySQL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST["fullName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    if (empty($fullName) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo json_encode(["status" => "error", "message" => "Vui lòng điền đầy đủ thông tin"]);
        exit;
    }

    if ($password !== $confirmPassword) {
        echo json_encode(["status" => "error", "message" => "Mật khẩu không khớp"]);
        exit;
    }

    if (strlen($password) < 6) {
        echo json_encode(["status" => "error", "message" => "Mật khẩu phải có ít nhất 6 ký tự"]);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Kiểm tra email đã tồn tại
    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email đã tồn tại"]);
        exit;
    }

    // Thêm người dùng mới
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $fullName, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Đăng ký thành công"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi khi đăng ký"]);
    }
}
?>
