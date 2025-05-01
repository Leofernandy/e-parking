<?php
require_once 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nama'] = $user['nama'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['no_hp'] = $user['no_hp'];
        $_SESSION['is_active'] = $user['is_active'];
        $_SESSION['foto_profile'] = $user['foto_profile'];

        $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?")->execute([$user['id']]);

        header("Location: reservasi.php");
        exit();
    } else {
        $_SESSION['error'] = "Email atau password salah!"; // Simpan pesan error
        header("Location: login.php"); // Balik ke login.php
        exit();
    }
}
?>
