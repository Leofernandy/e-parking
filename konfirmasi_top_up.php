<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href = 'login.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $amount = (int)$_POST['amount'];
    $method = $_POST['method'];

    if ($amount < 10000) {
        echo "<script>alert('Minimal topup Rp10.000'); window.location.href = 'topup.php';</script>";
        exit();
    }

    try {


        
        $pdo->beginTransaction();

        // Update saldo user
        $updateSaldo = $pdo->prepare("UPDATE users SET saldo = saldo + :amount WHERE id = :user_id");
        $updateSaldo->execute([
            ':amount' => $amount,
            ':user_id' => $userId
        ]);

        // Insert ke riwayat topup
        $insertTopup = $pdo->prepare("INSERT INTO topup_history (user_id, amount, method) VALUES (:user_id, :amount, :method)");
        $insertTopup->execute([
            ':user_id' => $userId,
            ':amount' => $amount,
            ':method' => $method
        ]);


        $pdo->commit();

        header('Location: success.php');
        exit();

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<script>alert('Topup Gagal: " . $e->getMessage() . "'); window.location.href = 'topup.php';</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Top Up - Parkeer</title>
    <link rel="shortcut icon" href="assets/img/Logobgwhite.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        .fixed-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
        }
        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .sidebar {
            position: fixed;
            top: 70px;
            left: -250px;
            width: 250px;
            height: calc(100vh - 70px);
            background: #2E4A5E;
            transition: 0.3s;
            padding-top: 20px;
            overflow-y: auto;
        }
        .sidebar.active {
            left: 0;
        }
        .sidebar a {
            padding: 10px 20px;
            display: block;
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #243b53;
        }
        .confirm-container {
            max-width: 600px;
            margin: 100px auto 50px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .error-text {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body onload="loadPaymentMethod()">

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-header">
    <div class="d-flex align-items-center">
        <button class="btn btn-light me-3" id="menu-toggle"><i class="bi bi-list"></i></button>
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="assets/img/Logobgwhite.png" alt="Parkeer Logo" width="40" class="me-2">
            <span class="fw-bold fs-3 text-navy">Parkeer</span>
        </a>
    </div>
    <div class="d-flex align-items-center">
        <img src="<?php echo $_SESSION['foto_profile']; ?>" alt="Foto Profil" class="profile-img me-2">
        <span class="fw-bold text-navy"><?php echo htmlspecialchars($_SESSION['user_nama']); ?></span>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <a href="reservasi.php">Reservasi</a>
    <a href="riwayat.php">Riwayat Pemesanan</a>
    <a href="dompet.php">Dompet</a>
    <a href="PengaturanAkun.php">Akun</a>
    <a href="bantuan.php">Notifikasi</a>
</div>

<!-- Content -->
<div class="container">
    <div class="confirm-container">
        <h3>Konfirmasi Pembayaran</h3>
        <p>Anda memilih metode:</p>
        <h4 id="paymentMethod"></h4>

        <div class="mt-3">
            <label for="amount" class="form-label">Masukkan Nominal:</label>
            <input type="number" id="amount" class="form-control" placeholder="Min. Rp10.000" oninput="validateAmount()">
            <span id="errorText" class="error-text"></span>
        </div>

        <p class="mt-3">Silakan lanjutkan ke pembayaran.</p>

        <button id="submitBtn" class="btn btn-primary" disabled onclick="showConfirmationPopup()">Lanjutkan</button>
        <a href="topup.php" class="btn btn-secondary">Batal</a>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Akhir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Metode Pembayaran: <span id="popupMethod"></span></p>
                <p>Nominal: <strong id="popupAmount"></strong></p>
                <p>Pastikan data sudah benar sebelum melanjutkan.</p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="konfirmasi_top_up.php">
                    <input type="hidden" name="amount" id="amountInputHidden" required>
                    <input type="hidden" name="method" id="methodInputHidden" required>
                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JS Bootstrap & Sidebar -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('menu-toggle').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('active');
    });

    function loadPaymentMethod() {
    const urlParams = new URLSearchParams(window.location.search);
    const method = urlParams.get('method');
    document.getElementById('paymentMethod').textContent = method || 'Metode Tidak Diketahui';
    }

    window.addEventListener('DOMContentLoaded', loadPaymentMethod);


    function validateAmount() {
        const amount = document.getElementById("amount").value;
        const errorText = document.getElementById("errorText");
        const submitBtn = document.getElementById("submitBtn");

        if (!amount || isNaN(amount) || amount < 10000) {
            errorText.textContent = "Minimal top-up Rp10.000";
            submitBtn.disabled = true;
        } else {
            errorText.textContent = "";
            submitBtn.disabled = false;
        }
    }

    function showConfirmationPopup() {
        const amount = document.getElementById("amount").value;
        const method = document.getElementById("paymentMethod").textContent;

        document.getElementById("popupMethod").textContent = method;
        document.getElementById("popupAmount").textContent = "Rp" + parseInt(amount).toLocaleString('id-ID');

        document.getElementById("amountInputHidden").value = amount;
        document.getElementById("methodInputHidden").value = method;

        const popup = new bootstrap.Modal(document.getElementById("confirmationModal"));
        popup.show();
    }
</script>

</body>
</html>
