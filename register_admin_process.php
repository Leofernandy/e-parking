<?php
session_start();

try {
    $pdo = new PDO("mysql:host=localhost;dbname=parkeer_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Ambil data dari form
$username = $_POST['username'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$password = $_POST['password'];
$konfirmasi_password = $_POST['konfirmasi_password'];

// Cek konfirmasi password
if ($password !== $konfirmasi_password) {
    echo "<script>alert('Konfirmasi password tidak sesuai!'); window.location.href='register_admin.php';</script>";
    exit();
}

// Cek apakah username sudah ada
$stmt = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE username = ?");
$stmt->execute([$username]);
if ($stmt->fetchColumn() > 0) {
    echo "<script>alert('Username sudah digunakan!'); window.location.href='register_admin.php';</script>";
    exit();
}

// Insert data ke tabel admins
$stmt = $pdo->prepare("INSERT INTO admins (username, password, nama, email, level, created_at, is_active) VALUES (?, ?, ?, ?, ?, NOW(), ?)");
$stmt->execute([
    $username,
    $password,       // <-- TANPA HASH sesuai permintaan
    $nama,
    $email,
    'admin',         // default level admin
    1                // is_active = 1 (aktif)
]);

// Setelah daftar, bisa langsung diarahkan ke login
echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='admin_login.php';</script>";
exit();
?>
