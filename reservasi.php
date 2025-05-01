<?php
session_start();
require 'config.php';



if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location.href = 'login.php';
    </script>";
    exit();
}
$userId = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT saldo FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $saldo = $user['saldo'];
    } else {
        $saldo = 0; // default kalau user tidak ditemukan
    }
} catch (Exception $e) {
    $saldo = 0; // kalau error, set saldo ke 0
}

// Ambil jumlah slot yang tersedia berdasarkan mall_id
try {
    // Query untuk menghitung jumlah slot available berdasarkan mall_id
    $stmt = $pdo->prepare("SELECT mall_id, COUNT(*) as available_slots 
                           FROM Parking_slots 
                           WHERE status = 'available' 
                           GROUP BY mall_id");
    $stmt->execute();
    $availableSlots = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Membuat array untuk menyimpan jumlah slot yang tersedia berdasarkan mall_id
    $availableSlotsArray = [];
    foreach ($availableSlots as $slot) {
        $availableSlotsArray[$slot['mall_id']] = $slot['available_slots'];
    }
} catch (Exception $e) {
    $availableSlotsArray = [];
    echo 'Error: ' . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi - Parkeer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

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
        .saldo-container {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #2E4A5E;
            color: white;
            padding: 10px 15px;
            border-radius: 10px;
        }
        .saldo-container button {
            background: #FFD700;
            border: none;
            color: #2E4A5E;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
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
        .mall-card {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .mall-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px; /* Menambahkan jarak bawah antara gambar dan tulisan */
        }

        .mall-card h5 {
            margin-top: 10px; /* Menambahkan jarak atas pada tulisan */
        }

        .mall-card button {
            margin-top: 10px;
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
    <div class="content container mt-5 pt-5">
        <h2 class="text-navy">Reservasi Parkir</h2>

        <div class="row">
            <div class="col-md-6">
            <div class="saldo-container mb-3">
            <span>Saldo: Rp <?php echo number_format($saldo, 0, ',', '.'); ?></span>
            <a href="topup.php"><button id="top-up">Top Up</button></a>
            
        </div>
                <form id="mallForm" action="bayar.php" method="POST">
                <div class="mb-3" id="mall-select-container" >
                    <label for="mall_id" class="form-label">Pilih Mall</label>
                    <select class="form-select" id="mall_id" name="mall_id">

                        <option selected disabled>Pilih Mall </option>
                        <option value="1" data-img="assets/img/mall1.jpg">Centre Point Mall</option>
                        <option value="2" data-img="assets/img/mall2.jpg">Sun Plaza</option>
                        <option value="3" data-img="assets/img/mall3.jpg">DeliPark Mall</option>
                    </select>
                </div>
                    <input type="hidden" name="nama_mall" id="nama_mall">
                    <input type="hidden" name="harga_per_jam" id="harga_per_jam">
                    <input type="hidden" name="alamat_mall" id="alamat_mall">
                    <input type="hidden" name="gambar_mall" id="gambar_mall">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal">
                    </div>
                    <div class="mb-3">
                        <label for="waktu" class="form-label">Waktu</label>
                        <input type="time" class="form-control" id="waktu">
                    </div>
                    <button type="submit" class="btn-navy"> Reservasi Sekarang</button>
                </form>
            </div>
            <div class="col-md-6">
            <div class="col-md-6">
                <div id="map" style="width: 100%; height: 400px; width: 637px; border-radius: 10px;"></div>
            </div>

            </div>
        </div>
        <h3 class="mt-4">Saran Lokasi</h3>
        <div class="row">
        <div class="col-md-4">
                <div class="mall-card shadow-lg rounded-3 p-3 text-center">
                    <img src="assets/img/mall1.jpg" alt="DeliPark Mall" class="img-fluid rounded-3">
                    <h5 class="mt-3 fw-bold">Centre Point Mall</h5>
                    <p class="text-muted">IDR Rp 5.000/jam</p>
                    <p class="text-success fw-semibold">Slot Tersedia: <?php echo isset($availableSlotsArray[1]) ? $availableSlotsArray[1] : 0; ?></p>
                    <form action="bayar.php" method="POST">
                        <input type="hidden" name="mall_id" value="1"> <!-- 1 = Centre Point Mall -->
                        <input type="hidden" name="nama_mall" value="Centre Point Mall">
                        <input type="hidden" name="harga_per_jam" value="5000">
                        <input type="hidden" name="alamat_mall" value="Jalan Jawa, 8, Medan, Indonesia">
                        <input type="hidden" name="gambar_mall" value="assets/img/mall1.jpg">
                        <button type="submit" class="btn btn-navy w-100">Reservasi Sekarang</button>
                    </form>


                </div>
            </div>
            <div class="col-md-4">
                <div class="mall-card shadow-lg rounded-3 p-3 text-center">
                    <img src="assets/img/mall2.jpg" alt="DeliPark Mall" class="img-fluid rounded-3">
                    <h5 class="mt-3 fw-bold">Sun Plaza</h5>
                    <p class="text-muted">IDR Rp 6.000/jam</p>
                    <p class="text-success fw-semibold">Slot Tersedia: <?php echo isset($availableSlotsArray[2]) ? $availableSlotsArray[2] : 0; ?></p>
                    <form action="bayar.php" method="POST">
                        <input type="hidden" name="mall_id" value="2">
                        <input type="hidden" name="nama_mall" value="Sun Plaza">
                        <input type="hidden" name="harga_per_jam" value="6000">
                        <input type="hidden" name="alamat_mall" value="Jl. K.H. Zainul Arifin No.7, Medan">
                        <input type="hidden" name="gambar_mall" value="assets/img/mall2.jpg">
                        <button type="submit" class="btn btn-navy w-100">Reservasi Sekarang</button>
                    </form>

                </div>
            </div>
            <div class="col-md-4">
                <div class="mall-card shadow-lg rounded-3 p-3 text-center">
                    <img src="assets/img/mall3.jpg" alt="DeliPark Mall" class="img-fluid rounded-3">
                    <h5 class="mt-3 fw-bold">DeliPark Mall</h5>
                    <p class="text-muted">IDR Rp 6.000/jam</p>
                    <p class="text-success fw-semibold">Slot Tersedia: <?php echo isset($availableSlotsArray[3]) ? $availableSlotsArray[3] : 0; ?></p>
                    <form action="bayar.php" method="POST">
                        <input type="hidden" name="mall_id" value="3">
                        <input type="hidden" name="nama_mall" value="Deli Park Mall">
                        <input type="hidden" name="harga_per_jam" value="6000">
                        <input type="hidden" name="alamat_mall" value="Jl. Putri Hijau Dalam No.1, Medan">
                        <input type="hidden" name="gambar_mall" value="assets/img/mall3.jpg">
                        <button type="submit" class="btn btn-navy w-100">Reservasi Sekarang</button>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
    <script>
    // Data lengkap mall
    const mallData = {
        1: {
            name: "Centre Point Mall",
            harga: 5000,
            alamat: "Jalan Jawa, 8, Medan, Indonesia",
            gambar: "assets/img/mall1.jpg"
        },
        2: {
            name: "Sun Plaza",
            harga: 6000,
            alamat: "Jl. K.H. Zainul Arifin No.7, Medan",
            gambar: "assets/img/mall2.jpg"
        },
        3: {
            name: "Deli Park Mall",
            harga: 6000,
            alamat: "Jl. Putri Hijau Dalam No.1, Medan",
            gambar: "assets/img/mall3.jpg"
        }
    };

    document.getElementById('mall_id').addEventListener('change', function () {
        const mallId = this.value;
        const mall = mallData[mallId];

        if (mall) {
            // Isi hidden input
            document.getElementById('nama_mall').value = mall.name;
            document.getElementById('harga_per_jam').value = mall.harga;
            document.getElementById('alamat_mall').value = mall.alamat;
            document.getElementById('gambar_mall').value = mall.gambar;
        }
    });

    // Inisialisasi peta Leaflet
    const map = L.map('map').setView([3.5952, 98.6722], 13); // Lokasi default: Medan

    // Tambahkan layer peta
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap',
        maxZoom: 18
    }).addTo(map);

    // Data mall dengan koordinat
    const mallLocations = {
        1: {
            name: "Centre Point Mall",
            lat: 3.591650247047374, 
            lng: 98.68068514417635
        },
        2: {
            name: "Sun Plaza",
            lat: 3.583430159402525, 
            lng: 98.67153225776613
        },
        3: {
            name: "DeliPark Mall",
            lat: 3.594592719574755, 
            lng: 98.67438593776994
        }
    };

    let currentMarker = null;

    // Saat dropdown mall dipilih
    document.getElementById('mall_id').addEventListener('change', function () {
        const mallId = this.value;
        const mall = mallLocations[mallId];

        if (mall) {
            // Pindah dan zoom ke mall
            map.setView([mall.lat, mall.lng], 17);

            // Hapus marker lama jika ada
            if (currentMarker) {
                map.removeLayer(currentMarker);
            }

            // Tambahkan marker baru
            currentMarker = L.marker([mall.lat, mall.lng])
                .addTo(map)
                .bindPopup(`<b>${mall.name}</b>`)
                .openPopup();
        }
    });
</script>


</body>
</html>
