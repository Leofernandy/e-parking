<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2E4A5E;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 450px;
            margin: 140px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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

        .header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #2E4A5E;
            padding: 15px 0;
        }
        .profile-section {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            background: #fff;
            border-radius: 10px;
        }
        .profile-section img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }
        .profile-info {
            flex-grow: 1;
        }
        .profile-info p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        .edit-icon {
            color: #d32f2f;
            cursor: pointer;
            font-size: 18px;
        }
        .menu-section {
            margin-top: 20px;
        }
        .menu-section h2 {
            font-size: 18px;
            color: #333;
            margin-bottom: 12px;
        }
        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 8px;
            background: #f5f5f5;
            margin-bottom: 10px;
            cursor: pointer;
            transition: 0.3s;
        }
        .menu-item:hover {
            background: #e0e0e0;
        }

        a{
            text-decoration:none;
            color:black;
        }
    </style>
</head>
<body>
    
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
        <a href="#">Reservasi</a>
        <a href="riwayat.php">Riwayat Pemesanan</a>
        <a href="#">Dompet</a>
        <a href="#">Akun</a>
        <a href="bantuan.php">Bantuan</a>
    </div>
    <div class="container">
        <div class="header">Akun Saya</div>
        <div class="profile-section">
            <img src="profile.jpg" alt="Profile Picture">
            <div class="profile-info">
                <p><strong>Leo</strong></p>
                <p>+62 896 3637 0095</p>
                <p>example@mail.com</p>
            </div>
            <span class="edit-icon">✏️</span>
        </div>
        <div class="menu-section">
            <h2>Pengaturan & Keamanan</h2>
            <div class="menu-item">🔒 Atur Keamanan</div>
            <div class="menu-item"><a href="http://localhost/23SI2/Parkeer/Edit%20Vehicle.php">🚗 Kelola Kendaraan</a></div>
            <div class="menu-item">🌍 Pilih Bahasa</div>
            <div class="menu-item">🎁 Bagikan & Dapatkan Bonus</div>
        </div>
        <div class="menu-section">
            <h2>Bantuan & Informasi</h2>
            <div class="menu-item">📖 Panduan Pengguna</div>
            <div class="menu-item">📍 Lokasi Favorit Saya</div>
            <div class="menu-item">❓ Pusat Bantuan</div>
            <div class="menu-item">💬 Hubungi Customer Service</div>
        </div>
    </div>
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>
