<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $no_hp = trim($_POST['no_hp']);
    $password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    // Cek konfirmasi password
    if ($password !== $konfirmasi_password) {
        $_SESSION['error'] = "Password dan konfirmasi tidak cocok!";
        header("Location: registrasi.php");
        exit();
    }

    // Cek apakah email sudah terdaftar
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "Email sudah terdaftar!";
        header("Location: registrasi.php");
        exit();
    }

    // Insert user baru
    $stmt = $pdo->prepare("INSERT INTO users (nama, email, no_hp, password, foto_profile, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $success = $stmt->execute([$nama, $email, $no_hp, $password, 'assets/img/defaultpp.jpg']);


    if ($success) {
        $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
        header("Location: registrasi.php");
        exit();
    } else {
        $_SESSION['error'] = "Terjadi kesalahan saat registrasi.";
        header("Location: registrasi.php");
        exit();
    }
}
?>
