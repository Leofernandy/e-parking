<?php
session_start();
require 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location.href = 'login.php';
    </script>";
    exit();
}

// Ambil user_id dari session
$user_id = $_SESSION['user_id'];


// Ambil data riwayat pemesanan berdasarkan user_id dan status 'pending'
$stmt = $pdo->prepare("SELECT * FROM reservations WHERE user_id = :user_id AND status = 'pending' ORDER BY created_at DESC");
$stmt->execute(['user_id' => $user_id]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil data reservasi dengan status 'completed'
$stmt = $pdo->prepare("SELECT * FROM reservations WHERE user_id = :user_id AND status = 'completed' ORDER BY created_at DESC");
$stmt->execute(['user_id' => $user_id]);
$completed_reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil data reservasi dengan status 'cancelled'
$stmt = $pdo->prepare("SELECT * FROM reservations WHERE user_id = :user_id AND status = 'cancelled' ORDER BY created_at DESC");
$stmt->execute(['user_id' => $user_id]);
$cancelled_reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);


foreach ($reservations as &$reservation) {
    // Ambil data slot parkir
    $stmt = $pdo->prepare("SELECT slot_code FROM parking_slots WHERE id = :parking_slot_id");
    $stmt->execute(['parking_slot_id' => $reservation['parking_slot_id']]);
    $slot = $stmt->fetch();
    $reservation['slot_code'] = $slot ? $slot['slot_code'] : 'Tidak ditemukan';

    // Ambil data nomor kendaraan
    $stmt = $pdo->prepare("SELECT plate FROM vehicles WHERE id = :vehicle_id");
    $stmt->execute(['vehicle_id' => $reservation['vehicle_id']]);
    $vehicle = $stmt->fetch();
    $reservation['plate'] = $vehicle ? $vehicle['plate'] : 'Tidak ditemukan';
}

// Proses pembatalan reservasi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_reservation'])) {
    $reservation_id = $_POST['cancel_reservation'];

    // Ambil data reservasi untuk pembatalan
    $stmt = $pdo->prepare("SELECT * FROM reservations WHERE id = :reservation_id AND user_id = :user_id");
    $stmt->execute(['reservation_id' => $reservation_id, 'user_id' => $user_id]);

    $reservation = $stmt->fetch();

    if ($reservation) {
        // Kembalikan saldo ke user
        $stmt = $pdo->prepare("UPDATE users SET saldo = saldo + :biaya WHERE id = :user_id");
        $stmt->execute(['biaya' => $reservation['biaya'], 'user_id' => $user_id]);
        // Masukkan transaksi refund ke dalam topup_history dengan method 'Refund Pembatalan Reservasi'
        $stmtTopup = $pdo->prepare("INSERT INTO topup_history (user_id, amount, method, created_at) VALUES (:user_id, :amount, :method, NOW())");
        $stmtTopup->execute([
            'user_id' => $user_id,
            'amount' => $reservation['biaya'],
            'method' => 'Refund Pembatalan Reservasi' // Metode refund
        ]);

        // Ubah status slot parkir menjadi available
        $stmt = $pdo->prepare("UPDATE parking_slots SET status = 'available' WHERE id = :parking_slot_id");
        $stmt->execute(['parking_slot_id' => $reservation['parking_slot_id']]);

        // Update status reservasi menjadi canceled
        $stmt = $pdo->prepare("UPDATE reservations SET status = 'cancelled' WHERE id = :reservation_id");
        $stmt->execute(['reservation_id' => $reservation_id]);

        echo "<script>alert('Reservasi berhasil dibatalkan!'); window.location.href='riwayat.php';</script>";
        exit();
    } else {
        echo "<script>alert('Reservasi tidak ditemukan!'); window.location.href='riwayat.php';</script>";
        exit();
    }
}

// Proses perubahan status dari 'pending' ke 'completed'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['complete_reservation'])) {
    $reservation_id = $_POST['complete_reservation'];

    // Ambil data reservasi berdasarkan id
    $stmt = $pdo->prepare("SELECT * FROM reservations WHERE id = :reservation_id AND user_id = :user_id");
    $stmt->execute(['reservation_id' => $reservation_id, 'user_id' => $user_id]);

    $reservation = $stmt->fetch();

    if ($reservation) {
        // Update status reservasi menjadi 'completed'
        $stmt = $pdo->prepare("UPDATE reservations SET status = 'completed' WHERE id = :reservation_id");
        $stmt->execute(['reservation_id' => $reservation_id]);
        // Ubah status slot parkir menjadi available
        $stmt = $pdo->prepare("UPDATE parking_slots SET status = 'available' WHERE id = :parking_slot_id");
        $stmt->execute(['parking_slot_id' => $reservation['parking_slot_id']]);
        

        echo "<script>alert('Reservasi berhasil diselesaikan!'); window.location.href='riwayat.php';</script>";
        exit();
    } else {
        echo "<script>alert('Reservasi tidak ditemukan!'); window.location.href='riwayat.php';</script>";
        exit();
    }
}

function getMallName($mall_id) {
    switch ($mall_id) {
        case 1: return 'Centre Point Mall';
        case 2: return 'Sun Plaza';
        case 3: return 'DeliPark Mall';
        default: return 'Mall tidak ditemukan';
    }
}

?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan - Parkeer</title>
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
            z-index: 1000;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }
        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .qr-code {
            max-width: 200px;
            margin-bottom: 20px;
        }

        .card-container {
            margin-top: 100px;
            padding: 20px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .card {
            background-color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            margin: 0 auto;

        }

        .card-body {
            padding: 20px;
            text-align: center;
        }

        .card-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #2E4A5E;
        }

        .detail-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }

        .detail-table th, .detail-table td {
            padding: 12px 20px;
            text-align: left;
            vertical-align: middle;
            border-bottom: 1px solid #ddd;
        }

        .detail-table th {
            background-color: #2E4A5E;
            color: white;
            font-size: 16px;
        }


        .detail-table td {
            background-color: #f9f9f9;
            font-size: 14px;
            color: #333;
        }

        .detail-table tr:hover td {
            background-color: #f1f1f1;
        }

        .detail-table tr:last-child td {
            border-bottom: none;
        }

        .button-container {
            margin-top: 10px;
        }


        .btn-custom {
            width: 100%;
            max-width: 200px;
            margin: 5px;
            radius:10px;
        }

        .btn-primary{
            background: #2E4A5E;
            color:white;


        }

    
        .sidebar {
            position: fixed;
            left: -250px;
            top: 70px;
            width: 250px;
            height: calc(100vh - 70px);
            background: #2E4A5E;
            color: white;
            transition: 0.3s;
            padding-top: 20px;
            overflow-y: auto;
            z-index:1000;
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
    </style>
</head>
<body>
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
    <div class="sidebar" id="sidebar">
        <a href="reservasi.php">Reservasi</a>
        <a href="riwayat.php">Riwayat Pemesanan</a>
        <a href="dompet.php">Dompet</a>
        <a href="PengaturanAkun.php">Akun</a>
        <a href="bantuan.php">Notifikasi</a>
    </div>
    

    <!-- Content -->
    <div class="container card-container">

    <!-- Pending Reservations -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mt-3 mb-3">Reservasi Aktif</h5>
            <?php if (empty($reservations)) : ?>
                <p class="text-center text-muted">Belum ada booking.</p>
            <?php else : ?>
                <?php foreach ($reservations as $reservation): ?>
                    <hr>
                    <img src="assets/img/qr.png" alt="QR Code" class="qr-code">
                    <table class="table detail-table mx-auto">
                        <tr><th>Booking ID</th><td><?= htmlspecialchars($reservation['booking_code']); ?></td></tr>
                        <tr><th>Nama Lokasi</th><td><?= getMallName($reservation['mall_id']); ?></td></tr>
                        <tr><th>Slot Parkir</th><td><?= htmlspecialchars($reservation['slot_code']); ?></td></tr>
                        <tr><th>Nomor Kendaraan</th><td><?= htmlspecialchars($reservation['plate']); ?></td></tr>
                        <tr><th>Waktu Masuk</th><td><?= date("Y-m-d H:i", strtotime($reservation['waktu_masuk'])); ?></td></tr>
                        <tr><th>Waktu Keluar</th><td><?= date("Y-m-d H:i", strtotime($reservation['waktu_keluar'])); ?></td></tr>
                        <tr><th>Durasi</th><td><?= htmlspecialchars($reservation['durasi']); ?> menit</td></tr>
                        <tr><th>Biaya</th><td>Rp <?= number_format($reservation['biaya'], 0, ',', '.'); ?></td></tr>
                        <tr><th>Metode Pembayaran</th><td><?= htmlspecialchars($reservation['metode_pembayaran']); ?></td></tr>
                    </table>
                    <div class="button-container d-flex justify-content-center">
                        <form action="riwayat.php" method="POST" class="me-2">
                            <input type="hidden" name="cancel_reservation" value="<?= $reservation['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-custom">Batal</button>
                        </form>
                        <form action="riwayat.php" method="POST">
                            <input type="hidden" name="complete_reservation" value="<?= $reservation['id']; ?>">
                            <button type="submit" class="btn btn-primary btn-custom">Selesai</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Completed Reservations -->
    <?php if (!empty($completed_reservations)): ?>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mt-3 mb-3">Reservasi Selesai</h5>
                <?php foreach ($completed_reservations as $reservation): ?>
                    <div class="mb-3 p-3 border rounded bg-light">
                        <p><strong>Booking ID:</strong> <?= htmlspecialchars($reservation['booking_code']); ?></p>
                        <p><strong>Mall:</strong> <?= getMallName($reservation['mall_id']); ?></p>
                        <p><strong>Waktu Masuk:</strong> <?= date("Y-m-d H:i", strtotime($reservation['waktu_masuk'])); ?></p>
                        <p><span class="badge bg-success">Completed</span></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Cancelled Reservations -->
    <?php if (!empty($cancelled_reservations)): ?>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mt-3 mb-3">Reservasi Dibatalkan</h5>
                <?php foreach ($cancelled_reservations as $reservation): ?>
                    <div class="mb-3 p-3 border rounded bg-light">
                        <p><strong>Booking ID:</strong> <?= htmlspecialchars($reservation['booking_code']); ?></p>
                        <p><strong>Mall:</strong> <?= getMallName($reservation['mall_id']); ?></p>
                        <p><strong>Waktu Masuk:</strong> <?= date("Y-m-d H:i", strtotime($reservation['waktu_masuk'])); ?></p>
                        <p><span class="badge bg-danger">Cancelled</span></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>


    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>
