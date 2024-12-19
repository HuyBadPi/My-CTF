<?php

session_start(); // Khởi động session

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    header("Location: ./login.php");
    exit();
}

// Tạo OTP nếu chưa tồn tại
if (!isset($_SESSION['otp'])) {
    $otp = rand(1000, 9999); // Tạo mã OTP ngẫu nhiên
    $_SESSION['otp'] = $otp;
}


// Biến để hiển thị thông báo lỗi
$error_message = "";

// Xử lý khi form được gửi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['otp'])) {
        if ($_POST['otp'] == $_SESSION['otp']) {
            //unset($_SESSION['otp']); // Xóa OTP khỏi session
            // Chuyển hướng đến trang admin
            header("Location: ./admin.php");
            exit();
        } else {
            // Nếu OTP không chính xác
            $error_message = "Mã OTP không chính xác!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CTF 2FA Challenge</title>
    <script>
        // Hàm gửi số điện thoại qua AJAX
        function sendPhone() {
            const phone = document.getElementById('phone').value;
            const message = document.getElementById('message');

            // Gửi yêu cầu AJAX đến máy chủ
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "getnumero.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Xử lý phản hồi từ máy chủ
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    message.innerHTML = xhr.responseText; // Hiển thị phản hồi (OTP demo)
                }
            };

            // Gửi dữ liệu
            xhr.send("phone=" + encodeURIComponent(phone));
        }
    </script>
</head>
<body>
    <h1>Đăng nhập 2FA</h1>
    <p>Veuillez entrer votre numéro de téléphone. Nous vous enverrons un code de vérification OTP.</p>

    <!-- Form nhập số điện thoại -->
    <form onsubmit="event.preventDefault(); sendPhone();">
        <label for="phone">Số điện thoại:</label>
        <input type="tel" id="phone" name="phone" placeholder="Nhập số điện thoại của bạn" required pattern="\d{10}" title="Vui lòng nhập đúng số điện thoại (10 chữ số)">
        <button type="submit">Gửi OTP</button>
    </form>
    <div id="message"></div>

    <br>

    <!-- Form nhập OTP -->
    <form action="" method="POST">
        <label>Mã OTP:</label>
        <input type="text" name="otp" maxlength="4" required>
        <button type="submit">Xác thực</button>
    </form>

    <!-- Hiển thị thông báo lỗi nếu có -->
    <?php if (!empty($error_message)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>
    
    <br>

    <?php
        echo "##################################################<br>";
        echo "#                                                #<br>";                              
        echo "# FLAG: CTF_X_Y_{939976361471750270937373480650} #<br>";
        echo "#                                                #<br>";
        echo "##################################################<br>";
    ?>

</body>
</html>