<?php

include("./config/config.php");

try {
    // Establish database connection
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit();
};

// Handle login form submission
if (isset($_POST['login'])) {
    $usr = trim($_POST['username']); // Updated to match HTML form's name attribute
    $pwd = trim($_POST['password']); // Updated to match HTML form's name attribute

    if (!empty($usr) && !empty($pwd)) {
        // Use prepared statements for security
        $stmt = $db->prepare("SELECT * FROM $table_name WHERE username = :username AND password = :password");
        $stmt->execute([
            ':username' => $usr,
            ':password' => $pwd // Assuming password is stored as MD5 hash in DB
        ]);

        if ($stmt->rowCount() > 0) {
            session_start();
            session_regenerate_id(true);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];
            header("Location: ./dashboard.php");
            exit();
        } else {
            echo "Invalid credentials.";
        }
    } else {
        echo "Please fill all fields.";
    }
}
?>
