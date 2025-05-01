<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'config.php';

if (!isset($_SESSION['admin_id'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location.href = 'admin_login.php';
    </script>";
    exit();
}

$mall_name = '';

if (isset($_SESSION['mall_id'])) {
    $mall_id = $_SESSION['mall_id'];
    $stmt = $pdo->prepare("SELECT nama_mall , total_slot FROM malls WHERE id = :id");
    $stmt->execute([':id' => $mall_id]);
    $mall = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($mall) {
        $mall_name = $mall['nama_mall'];
        $total_slot = $mall['total_slot'];
    }
}

$stmt = $pdo->prepare("
    SELECT mall_id,
           SUM(CASE WHEN status = 'available' THEN 1 ELSE 0 END) AS available_slots,
           SUM(CASE WHEN status = 'booked' THEN 1 ELSE 0 END) AS booked_slots
    FROM parking_slots
    GROUP BY mall_id
");
$stmt->execute();
$slotData = $stmt->fetchAll(PDO::FETCH_ASSOC);

$availableSlotsArray = [];
$bookedSlotsArray = [];
foreach ($slotData as $slot) {
    $availableSlotsArray[$slot['mall_id']] = $slot['available_slots'];
    $bookedSlotsArray[$slot['mall_id']] = $slot['booked_slots'];
}

$available = isset($availableSlotsArray[$_SESSION['mall_id']]) ? $availableSlotsArray[$_SESSION['mall_id']] : 0;
$percentageAvailable = $total_slot > 0 ? ($available / $total_slot) * 100 : 0;

$booked = isset($bookedSlotsArray[$_SESSION['mall_id']]) ? $bookedSlotsArray[$_SESSION['mall_id']] : 0;
$percentageBooked = $total_slot > 0 ? ($booked / $total_slot) * 100 : 0;


$stmt = $pdo->prepare("SELECT * FROM reservations WHERE mall_id = :mall_id ORDER BY created_at DESC");
$stmt->bindParam(':mall_id', $mall_id, PDO::PARAM_INT);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
    $stmt = $pdo->prepare("SELECT * FROM reservations WHERE id = :reservation_id");
    $stmt->execute(['reservation_id' => $reservation_id]);

    $reservation = $stmt->fetch();

    if ($reservation) {

        // Ubah status slot parkir menjadi available
        $stmt = $pdo->prepare("UPDATE parking_slots SET status = 'available' WHERE id = :parking_slot_id");
        $stmt->execute(['parking_slot_id' => $reservation['parking_slot_id']]);

        // Update status reservasi menjadi canceled
        $stmt = $pdo->prepare("UPDATE reservations SET status = 'cancelled' WHERE id = :reservation_id");
        $stmt->execute(['reservation_id' => $reservation_id]);

        echo "<script>alert('Reservasi berhasil dibatalkan!'); window.location.href='dashboard.php';</script>";
        exit();
    } else {
        echo "<script>alert('Reservasi tidak ditemukan!'); window.location.href='dashboard.php';</script>";
        exit();
    }
}

// Proses perubahan status dari 'pending' ke 'completed'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['complete_reservation'])) {
    $reservation_id = $_POST['complete_reservation'];

    // Ambil data reservasi berdasarkan id
    $stmt = $pdo->prepare("SELECT * FROM reservations WHERE id = :reservation_id");
    $stmt->execute(['reservation_id' => $reservation_id]);

    $reservation = $stmt->fetch();

    if ($reservation) {
        // Update status reservasi menjadi 'completed'
        $stmt = $pdo->prepare("UPDATE reservations SET status = 'completed' WHERE id = :reservation_id");
        $stmt->execute(['reservation_id' => $reservation_id]);
        // Ubah status slot parkir menjadi available
        $stmt = $pdo->prepare("UPDATE parking_slots SET status = 'available' WHERE id = :parking_slot_id");
        $stmt->execute(['parking_slot_id' => $reservation['parking_slot_id']]);
        

        echo "<script>alert('Reservasi berhasil diselesaikan!'); window.location.href='dashboard.php';</script>";
        exit();
    } else {
        echo "<script>alert('Reservasi tidak ditemukan!'); window.location.href='dashboard.php';</script>";
        exit();
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="assets/img/Logobgwhite.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Parkeer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="shortcut icon" href="assets/img/Logobgwhite.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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
        
        .main-content {
            margin-top: 90px;
            margin-left: 20px;
            margin-right: 20px;
            transition: margin-left 0.3s;
        }
        
        .main-content.sidebar-active {
            margin-left: 270px;
        }

        /* Tombol Cari Parkir dan Reservasi */
        .btn-navy {
            background: #2E4A5E; /* Warna biru navbar */
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: normal;
            transition: background 0.3s, box-shadow 0.3s;
        }

        .btn-navy:hover {
            background: #243b53; /* Warna biru gelap saat hover */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .status-reserved {
            background-color: rgba(255, 193, 7, 0.1);
            border-left: 4px solid #FFC107;
        }
        .status-ongoing {
            background-color: rgba(23, 162, 184, 0.1);
            border-left: 4px solid #17A2B8;
        }
        .status-completed {
            background-color: rgba(40, 167, 69, 0.1);
            border-left: 4px solid #28A745;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-badge i {
            margin-right: 4px;
        }
        .parking-layout {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            gap: 10px;
            perspective: 1000px;
        }
        .parking-slot { height: 280px; border: 4px solid #2E4A5E; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; cursor: pointer; margin: 10px; border-right: none; border-radius: 5px; }
        .available { background-color: #243b53; color: white; }
        .occupied { background-color: rgb(255, 108, 108); color: white; cursor: not-allowed; }
        .selected { background-color: rgb(27, 105, 239) ; color: white; }
        .parking-slot-label {
            position: absolute;
            top: 5px;
            left: 5px;
            font-size: 0.7rem;
            opacity: 0.7;
        }
        .parking-lane {
            grid-column: 1 / -1;
            height: 30px;
            background-color: #f1f1f1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #666;
        }
        
        .text-navy {
            color: #2E4A5E;
        }
        
        .vehicle-icon {
            font-size: 1.2rem;
            margin-top: 2px;
        }
        .status-complete {
    background-color: #d4edda; /* hijau muda */
        }
        .status-pending {
            background-color: #fff3cd; /* kuning muda */
        }
        .status-cancel {
            background-color: #f8d7da; /* merah muda */
        }
        /* Style for the dropdown menu */
        .dropdown-menu {
        min-width: 150px;
        }


        
        
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-header">
        <div class="d-flex align-items-center">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="assets/img/Logobgwhite.png" alt="Parkeer Logo" width="40" class="me-2">
                <span class="fw-bold fs-3 text-navy">Parkeer Admin</span>
            </a>
        </div>
        <div class="d-flex align-items-center">
        <span class="fw-bold text-navy" id="admin-name"><?php echo htmlspecialchars($_SESSION['admin_nama']); ?></span>
        <div class="dropdown ml-3">
            <button class="btn btn-link text-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="admin_logout.php">Sign Out</a></li>
            </ul>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <div class="container-fluid">
            <!-- Header -->
            <header class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Parking Management System</h1>
                    <p class="text-gray-600"><?php echo htmlspecialchars($mall_name); ?></p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search vehicle/ticket" class="border rounded-md px-3 py-2 w-64">
                        <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                    </div>
                </div>
            </header>
            

            <div class="mb-8">
                <div class="bg-white shadow-md rounded-lg p-3">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-2xl font-semibold">
                            <i class="fas fa-parking text-blue-600 mr-2"></i>Floor 1 Status
                        </h2>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Last updated: 11:30 AM</span>
                            <button class="text-blue-500 hover:text-blue-700">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Main stats with visual indicators -->
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex-1 text-center p-3 border-r">
                            <p class="text-gray-600 text-sm">Total Slots</p>
                            <p class="text-2xl font-bold"><?php echo htmlspecialchars($total_slot); ?></p>
                            
                        </div>
                        <div class="flex-1 text-center p-3 border-r">
                            <p class="text-gray-600 text-sm">Available</p>
                            <p class="text-2xl font-bold text-green-600"><?php echo isset($availableSlotsArray[$_SESSION['mall_id']]) ? $availableSlotsArray[$_SESSION['mall_id']] : 0; ?></p>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: <?php echo $percentageAvailable; ?>%"></div>
                            </div>
                        </div>
                        <div class="flex-1 text-center p-3">
                            <p class="text-gray-600 text-sm">Booked</p>
                            <p class="text-2xl font-bold text-red-600"><?php echo isset($bookedSlotsArray[$_SESSION['mall_id']]) ? $bookedSlotsArray[$_SESSION['mall_id']] : 0; ?></p>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-red-500 h-2 rounded-full" style="width: <?php echo $percentageBooked; ?>%"></div>
                            </div>
                        </div>
                    </div>
                    
        
                </div>
            </div>
            
            <!-- Parking Slot Visualization -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">
                        <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>
                        Parking Slot Layout - Floor 1
                    </h2>
                    <div class="flex space-x-4">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-500 mr-2"></div>
                            <span>Available</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-500 mr-2"></div>
                            <span>Booked</span>
                        </div>
                    </div>
                </div>
                
                <!-- Parking Layout -->
                <div class="w-full px-4">
                <div class="grid grid-cols-3 gap-1" id="slot-container">
                    
                <?php
                $mall_id = $_SESSION['mall_id'] ?? 1; // default ke 1 kalau belum ada

                if ($mall_id == 1) {
                    $slotCodes = ['CP-P1', 'CP-P2', 'CP-P3', 'CP-P4', 'CP-P5', 'CP-P6', 'CP-P7', 'CP-P8', 'CP-P9'];
                } elseif ($mall_id == 2) {
                    $slotCodes = ['SP-P1', 'SP-P2', 'SP-P3', 'SP-P4', 'SP-P5', 'SP-P6', 'SP-P7', 'SP-P8', 'SP-P9'];
                } elseif ($mall_id == 3) {
                    $slotCodes = ['DP-P1', 'DP-P2', 'DP-P3', 'DP-P4', 'DP-P5', 'DP-P6', 'DP-P7', 'DP-P8', 'DP-P9'];
                } else {
                    $slotCodes = []; // Kalau mall belum diatur
                }
                

                foreach ($slotCodes as $code) {
                    $stmt = $pdo->prepare("SELECT id, status FROM parking_slots WHERE slot_code = :slot_code AND mall_id = :mall_id");
                    $stmt->execute(['slot_code' => $code, 'mall_id' => $mall_id]);
                    $slot = $stmt->fetch();

                    if ($slot) {
                        $class = $slot['status'] === 'available' ? 'available' : 'occupied';
                        echo "<div class='parking-slot {$class}' data-id='{$slot['id']}'>" . htmlspecialchars($code) . "</div>";
                    } else {
                        echo "<div class='parking-slot occupied'>" . htmlspecialchars($code) . "</div>"; // Default kalau ga ketemu
                    }
                }
                ?>
                </div>
            </div>
            </div>
            




            <!-- Detailed Transaction Log -->
            <div class="bg-white shadow-md rounded-lg p-6 mt-8">
                <h2 class="text-xl font-semibold mb-4">
                    <i class="fas fa-list mr-2 text-gray-600"></i>Detailed Transaction Log
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3 text-left">Reservation Status</th>
                                <th class="p-3 text-left">Vehicle No</th>
                                <th class="p-3 text-left">Slot</th>
                                <th class="p-3 text-left">Entry Time</th>
                                <th class="p-3 text-left">Exit Time</th>
                                <th class="p-3 text-left">Duration</th>
                                <th class="p-3 text-left">Charge</th>
                                <th class="p-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservations as $reservation): ?>
                            <?php
                                $status = strtolower($reservation['status']);
                                $rowClass = '';
                                if ($status === 'completed') {
                                    $rowClass = 'status-complete';
                                } elseif ($status === 'reserved' || $status === 'pending') {
                                    $rowClass = 'status-pending';
                                } elseif ($status === 'cancelled' || $status === 'canceled') {
                                    $rowClass = 'status-cancel';
                                }
                                ?>
                                <tr class="border-b <?php echo $rowClass; ?>">
                                <td class="p-3"><?php echo ucfirst(htmlspecialchars($reservation['status'])); ?></td>

                                <td class="p-3"><?php echo htmlspecialchars($reservation['plate']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($reservation['slot_code']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($reservation['waktu_masuk']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($reservation['waktu_keluar']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($reservation['durasi']); ?> menit</td>
                                <td class="p-3">Rp. <?php echo htmlspecialchars($reservation['biaya']); ?></td>
                                <td class="p-3">
                                <form method="POST" style="display:inline;">
                                    <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded text-xs mr-2" name="complete_reservation" value="<?= $reservation['id'] ?>">
                                        <i class="fas fa-edit mr-1"></i>Complete
                                    </button>
                                </form>
                                <form method="POST" style="display:inline;">
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded text-xs" name="cancel_reservation" value="<?= $reservation['id'] ?>">
                                        <i class="fas fa-times mr-1"></i>Cancel
                                    </button>
                                </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
document.getElementById('dropdownMenuButton').addEventListener('click', function() {
    const dropdownMenu = document.querySelector('.dropdown-menu');
    dropdownMenu.classList.toggle('show'); // toggle visibility of the dropdown
});
</script>


</html>
