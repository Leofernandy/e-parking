<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi - Parkeer</title>
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
            <img src="assets/img/profilepic.jpg" alt="Foto Profil" class="profile-img me-2">
            <span class="fw-bold text-navy">Fedor Reyes</span>
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
            <span>Saldo: Rp 250.000</span>
            <a href="topup.php"><button id="top-up">Top Up</button></a>
            
        </div>
                <form>
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" placeholder="Masukkan lokasi tujuan">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal">
                    </div>
                    <div class="mb-3">
                        <label for="waktu" class="form-label">Waktu</label>
                        <input type="time" class="form-control" id="waktu">
                    </div>
                    <button type="submit" class="btn-navy">Cari Lokasi</button>
                </form>
            </div>
            <div class="col-md-6">
                <iframe width="100%" height="400px" frameborder="0" style="border-radius: 10px;" src="assets/img/map.png" allowfullscreen></iframe>
            </div>
        </div>
        <h3 class="mt-4">Pilih Lokasi Parkir</h3>
        <div class="row">
        <div class="col-md-4">
                <div class="mall-card shadow-lg rounded-3 p-3 text-center">
                    <img src="assets/img/mall1.jpg" alt="DeliPark Mall" class="img-fluid rounded-3">
                    <h5 class="mt-3 fw-bold">Centre Point Mall</h5>
                    <p class="text-muted">IDR Rp 5.000/jam</p>
                    <p class="text-success fw-semibold">Slot Tersedia: 12</p>
                    <a href="bayar.php" class="btn btn-navy w-100">Reservasi Sekarang</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mall-card shadow-lg rounded-3 p-3 text-center">
                    <img src="assets/img/mall2.jpg" alt="DeliPark Mall" class="img-fluid rounded-3">
                    <h5 class="mt-3 fw-bold">Sun Plaza</h5>
                    <p class="text-muted">IDR Rp 6.000/jam</p>
                    <p class="text-success fw-semibold">Slot Tersedia: 5</p>
                    <button class="btn btn-navy w-100">Reservasi Sekarang</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mall-card shadow-lg rounded-3 p-3 text-center">
                    <img src="assets/img/mall3.jpg" alt="DeliPark Mall" class="img-fluid rounded-3">
                    <h5 class="mt-3 fw-bold">DeliPark Mall</h5>
                    <p class="text-muted">IDR Rp 6.000/jam</p>
                    <p class="text-success fw-semibold">Slot Tersedia: 12</p>
                    <button class="btn btn-navy w-100">Reservasi Sekarang</button>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>
