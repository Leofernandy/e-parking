<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'config.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Admin - Parkeer</title>
    <link rel="shortcut icon" href="assets/img/Logobgwhite.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="assets/img/Logobgwhite.png" alt="Parkeer Logo" width="40" class="me-2">
                <span class="text-navy fw-bold fs-3">Parkeer</span>
            </a>
        </div>
    </nav>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4 rounded-4" style="width: 100%; max-width: 400px;">
            <h2 class="text-center mb-4 text-navy">Daftar Admin Parkeer</h2>

            <form action="register_admin_process.php" method="POST">
                <div class="form-group mb-3">
                    <i class="bi bi-person"></i>
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="form-group mb-3">
                    <i class="bi bi-person"></i>
                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                </div>
                <div class="form-group mb-3">
                    <i class="bi bi-envelope"></i>
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="form-group mb-3">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Kata Sandi" required>
                </div>
                <div class="form-group mb-3">
                    <i class="bi bi-lock-fill"></i>
                    <input type="password" name="konfirmasi_password" class="form-control" placeholder="Konfirmasi Kata Sandi" required>
                </div>
                <button type="submit" class="btn btn-navy w-100">Daftar</button>

                <div class="separator">atau</div>

                <p class="text-center mt-3">Sudah punya akun? <a href="admin_login.php">Masuk</a></p>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
