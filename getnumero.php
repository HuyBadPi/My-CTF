<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy số điện thoại từ form
    $phone = trim($_POST['phone']);

    // Kiểm tra định dạng số điện thoại (10 chữ số)
    if (preg_match("/^\d{10}$/", $phone)) {
        try {
            // Kết nối đến cơ sở dữ liệu challenge
            $db_host = 'localhost';
            $db_user = 'root';
            $db_pass = '';
            $db_name = 'challdifficile';
            $table_name = 'telephone';

            $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Chèn số điện thoại vào bảng numero
            $stmt = $db->prepare("INSERT INTO $table_name (telephone) VALUES (:phone)");
            $stmt->bindParam(':phone', $phone);

            // Thực thi câu lệnh
            if ($stmt->execute()) {
                echo "Số điện thoại đã được lưu thành công.";
            } else {
                echo "Không thể lưu số điện thoại. Vui lòng thử lại.";
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Mã lỗi trùng lặp
                echo "Số điện thoại này đã tồn tại.";
            } else {
                echo "Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage();
            }
        }
    } else {
        echo "Số điện thoại không hợp lệ. Vui lòng nhập lại.";
    }
} else {
    echo "Không có dữ liệu được gửi.";
}
?>
