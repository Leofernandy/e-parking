<?php
session_start();
try {
    $pdo = new PDO("mysql:host=localhost;dbname=parkeer_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];

$nama = $_POST['nama'];
$no_hp = $_POST['no_hp'];
$email = $_POST['email'];
$password_baru = $_POST['password_baru'] ?? ''; // Password baru (boleh kosong)

// Siapkan array parameter untuk query
$params = [$nama, $no_hp, $email];

// Cek apakah upload foto baru
if (isset($_FILES['foto_profile']) && $_FILES['foto_profile']['error'] == 0) {
    $foto = 'uploads/' . time() . '_' . $_FILES['foto_profile']['name'];
    move_uploaded_file($_FILES['foto_profile']['tmp_name'], $foto);
    $foto_sql = ", foto_profile = ?";
    $params[] = $foto;
    $_SESSION['foto_profile'] = $foto; // Update session foto
} else {
    $foto_sql = "";
}

// Cek apakah ganti password
if (!empty($password_baru)) {
    $password_sql = ", password = ?";
    $params[] = $password_baru;
} else {
    $password_sql = "";
}

$params[] = $userId;

// Build query dinamis
$stmt = $pdo->prepare("UPDATE users SET nama = ?, no_hp = ?, email = ?{$foto_sql}{$password_sql} WHERE id = ?");
$stmt->execute($params);

// Update nama di session juga
$_SESSION['user_nama'] = $nama;

header('Location: PengaturanAkun.php?update=success');
exit();
?>
