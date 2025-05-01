<?php
$host = 'localhost';
$db   = 'parkeer_db';
$user = 'root';  // ganti sesuai XAMPP kamu, biasanya 'root'
$pass = '';              // kalau XAMPP default, kosong saja
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
} catch (\PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
