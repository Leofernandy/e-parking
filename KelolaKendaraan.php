<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kendaraan</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #2E4A5E;
            text-align: center;
            margin: auto;
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

        header {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            padding: 15px;
            margin-top: 100px;
          margin-bottom: 30px;
            font-size: 18px;
            font-weight: bold;
            color: #2E4A5E;
            position: relative;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .back-btn {
            position: absolute;
            left: 30px;
            background: none;
            border: none;
            font-size: 45px;
            color: #2E4A5E;
            cursor: pointer;
        }
        .vehicle-card {
          width: 45%;
            background: white;
            margin: 10px auto;
            padding: 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .plate {
            background: black;
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .details {
            flex-grow: 1;
            padding: 0 15px;
            text-align: left;
        }
        .status {
            color: green;
            font-weight: bold;
        }
        .warning {
            color: red;
            font-size: 12px;
        }
        .edit-btn {
            color: white ;
            background: #2E4A5E;
            font-weight: bold;
            cursor: pointer;
            font-size: 15px;
          padding:15px;
          margin-right:30px;
        }
        .primary-btn {
            background: white;
            color: red;
            border: 2px solid red;
            padding: 10px;
            margin: 10px auto;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            display: block;
        }
        .add-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: red;
            color: white;
            font-size: 24px;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }
        .vehicle-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

      .status2{
        color: #2E4A5E;
            font-weight: bold;
            cursor: pointer;
        margin-left:5px;
        
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
        <a href="#">Reservasi</a>
        <a href="riwayat.php">Riwayat Pemesanan</a>
        <a href="#">Dompet</a>
        <a href="#">Akun</a>
        <a href="bantuan.php">Bantuan</a>
    </div>

    <header>
        <button class="back-btn">&lt;</button><a href="http://localhost/23SI2/Parkeer/Profile%20Settings.php"></a>
        <h1>Kendaraan</h1>
    </header>
    <main>
        <div class="vehicle-container">
            <section class="vehicle-card">
                <div class="plate">BK 1223 AEJ</div>
                <div class="details">
                    <h2>Toyota</h2>
                    <p>Putih <span class="status">⭐ Utama</span></p>
                    <p class="warning">⚠ Lengkapi data kendaraan anda</p>
                </div>
                <button class="edit-btn">UBAH</button>
            </section>
            <section class="vehicle-card">
                <div class="plate">BK 1182 GN</div>
                <div class="details">
                    <h2>Honda</h2>
                    <p>Hitam <button class="status2">Jadikan Utama</button></p>
                    <p class="warning">⚠ Lengkapi data kendaraan anda</p>
                </div>
                <button class="edit-btn">UBAH</button>
            </section>
    </div>
    </main>

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>
