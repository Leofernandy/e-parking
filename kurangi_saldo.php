<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login!'); window.location.href = 'login.php';</script>";
    exit();
}

$userId = $_SESSION['user_id'];
$amountToDeduct = 10000; // Contoh bayar Rp 10.000
$keterangan = 'Bayar parkir di Mall XYZ';

try {
    $conn->beginTransaction();

    $cekSaldo = $conn->prepare("SELECT saldo FROM users WHERE id = :user_id");
    $cekSaldo->execute([':user_id' => $userId]);
    $user = $cekSaldo->fetch();

    if ($user['saldo'] < $amountToDeduct) {
        throw new Exception('Saldo tidak cukup!');
    }

    $kurangSaldo = $conn->prepare("UPDATE users SET saldo = saldo - :amount WHERE id = :user_id");
    $kurangSaldo->execute([
        ':amount' => $amountToDeduct,
        ':user_id' => $userId
    ]);

    $insertTransaksi = $conn->prepare("INSERT INTO transaction_history (user_id, amount, keterangan) VALUES (:user_id, :amount, :keterangan)");
    $insertTransaksi->execute([
        ':user_id' => $userId,
        ':amount' => $amountToDeduct,
        ':keterangan' => $keterangan
    ]);

    $conn->commit();
    echo "Saldo berhasil dikurangi.";
} catch (Exception $e) {
    $conn->rollBack();
    echo "Gagal: " . $e->getMessage();
}
?>
