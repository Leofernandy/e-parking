<?php
session_start(); // HARUS ditaruh paling atas
require_once 'config.php';

$error = '';
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']); // supaya pesan error tidak muncul terus-menerus
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Masuk Parkeer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="shortcut icon" href="assets/img/Logobgwhite.png">
</head>
<body class="bg-light" class="admin-page">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="assets/img/Logobgwhite.png" alt="Parkeer Logo" width="40" class="me-2">
                <span class="text-navy fw-bold fs-3">Parkeer Admin</span>
            </a>
        </div>
    </nav>

    <!-- Admin Login Form -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4 rounded-4" style="width: 100%; max-width: 400px;">
            <h2 class="text-center mb-4 text-navy">Admin Login</h2>

            <!-- ALERT ERROR -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="admin_login_process.php" method="POST">
                <div class="form-group position-relative mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="form-group position-relative mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Kata Sandi" required>
                    <i class="bi bi-lock-fill"></i>
                </div>
                <button type="submit" class="btn btn-navy w-100">Masuk</button>
                <div class="separator">atau</div>

                <p class="text-center mt-3">Belum punya akun admin? <a href="registrasi_admin.php">Daftar</a></p>
                <p class="text-center mt-3">
                    <a href="login.php">Masuk sebagai User</a>
                </p>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
