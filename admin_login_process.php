<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->rowCount() == 1) {
        $admin = $stmt->fetch();

        if ($password === $admin['password']) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_nama'] = $admin['nama'];
            $_SESSION['admin_level'] = $admin['level'];
            $_SESSION['mall_id'] = $admin['mall_id'];

            $update = $pdo->prepare("UPDATE admins SET last_login = NOW() WHERE id = ?");
            $update->execute([$admin['id']]);

            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Username atau password salah!";
            header("Location: admin_login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Username atau password salah!";
        header("Location: admin_login.php");
        exit();
    }
}
?>
