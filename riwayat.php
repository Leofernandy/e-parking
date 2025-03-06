<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan - Parkeer</title>
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
            margin-top: 20px;
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
            <img src="assets/img/profilepic.jpg" alt="Foto Profil" class="profile-img me-2">
            <span class="fw-bold text-navy">Fedor Reyes</span>
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
        <div class="card">
            <div class="card-body">
                <!-- Title -->
                <h5 class="card-title mb-4">Detail Booking</h5>

                <!-- QR Code -->
                <img src="assets/img/qr.png" alt="QR Code" class="qr-code">

                <!-- Detail Parkir -->
                <table class="table detail-table mx-auto">
                    <tr>
                        <th>Booking ID</th>
                        <td>123456789</td>
                    </tr>
                    <tr>
                        <th>Nama Lokasi</th>
                        <td>Basement Centre Point Mall</td>
                    </tr>
                    <tr>
                        <th>Slot Parkir</th>
                        <td>P1</td>
                    </tr>
                    <tr>
                        <th>Nomor Kendaraan</th>
                        <td>BK73SUS</td>
                    </tr>
                    <tr>
                        <th>Waktu Masuk</th>
                        <td>2025-03-01 10:00</td>
                    </tr>
                    <tr>
                        <th>Waktu Keluar</th>
                        <td>2025-03-01 13:00</td>
                    </tr>
                    <tr>
                        <th>Durasi</th>
                        <td>3 jam 00 menit</td>
                    </tr>
                    <tr>
                        <th>Biaya</th>
                        <td>Rp 15.000</td>
                    </tr>
                    <tr>
                        <th>Metode Pembayaran</th>
                        <td>OVO</td>
                    </tr>
                </table>

                <!-- Button Group -->
                <div class="button-container">
                    <button class="btn btn-danger btn-custom">Batal</button>
                    <button class="btn btn-primary btn-custom">Perpanjang Durasi</button>
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
