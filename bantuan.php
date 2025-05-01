<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location.href = 'login.php';
    </script>";
    exit();
}

// Koneksi ke database menggunakan PDO
require_once 'config.php'; // Sesuaikan dengan file koneksi database yang kamu gunakan

// Ambil data transaksi pending dari database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM reservations WHERE user_id = :user_id AND status = 'pending' ORDER BY created_at DESC LIMIT 1";

$stmt = $pdo->prepare($query);

// Bind parameter
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

// Eksekusi query
$stmt->execute();

// Ambil hasil query
$transaction = $stmt->fetch(PDO::FETCH_ASSOC);

if ($transaction) {
    $waktu_keluar = $transaction['waktu_keluar']; // Asumsikan kolom exit_time berisi waktu keluar yang ditentukan
} else {
    $waktu_keluar = null;
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi - Parkeer</title>
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

        .card-custom {
            border-left: 8px solid;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            width: 100%;
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 8px;
        }
        .card-danger {
            background-color: #f8d7da;
            border-color: #dc3545;
        }
        .card-success {
            background-color: #d4edda;
            border-color: #28a745;
        }
        .timer {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 1.2rem;
            font-weight: bold;
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
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="reservasi.php">Reservasi</a>
        <a href="riwayat.php">Riwayat Pemesanan</a>
        <a href="dompet.php">Dompet</a>
        <a href="PengaturanAkun.php">Akun</a>
        <a href="bantuan.php">Notifikasi</a>
    </div>
    
    <!-- Content -->
    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        </nav>

        <div class="container-fluid mt-5 px-3">
            <h2 class="text-navy text-center fw-bold my-5 pt-3">Notifikasi</h2>
            <?php if ($transaction): ?>
            <div class="row justify-content-center pt-3">
                <div class="col-12">
                    <div class="card card-custom card-danger mb-2">
                        <div class="d-flex align-items-center pt-2">
                            <i class="bi bi-exclamation-triangle-fill fs-3 text-danger me-3"></i>
                            <div>
                                <h5 class="fw-bold text-danger">Perhatian!</h5>
                                <p>Reservasi anda akan berakhir pada <strong ><?php echo $waktu_keluar; ?></strong>.</p>
                            </div>
                        </div>
                        <span class="timer text-danger" id="sisaWaktu">00.00.00</span>
                    </div>
                </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="text-center mt-4">
                <a href="reservasi.php" class="btn btn-navy"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>
     
     
    

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        let sisaWaktu = document.getElementById("sisaWaktu");
        
        <?php if ($waktu_keluar): ?>
            // Menghitung waktu countdown berdasarkan waktu keluar yang didapat dari database
            let waktuKeluar = new Date("<?php echo $waktu_keluar; ?>").getTime();
            
            function updateCountdown() {
                let now = new Date().getTime();
                let sisaMs = waktuKeluar - now;

                if (sisaMs > 0) {
                    let sisaJam = Math.floor(sisaMs / (1000 * 60 * 60));
                    let sisaMenit = Math.floor((sisaMs % (1000 * 60 * 60)) / (1000 * 60));
                    let sisaDetik = Math.floor((sisaMs % (1000 * 60)) / 1000);
                    sisaWaktu.innerText = `${sisaJam.toString().padStart(2, '0')}:${sisaMenit.toString().padStart(2, '0')}:${sisaDetik.toString().padStart(2, '0')}`;
                } else {
                    sisaWaktu.innerText = "Waktu habis!";
                }
            }

            setInterval(updateCountdown, 1000);
        <?php else: ?>
            sisaWaktu.innerText = "Tidak ada transaksi pending";
        <?php endif; ?>
    });
</script>

</body>
</html>
