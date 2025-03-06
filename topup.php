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
    
    <!-- Content -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .top-up-container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-top : 100px;
        }
        .top-up-method {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        .top-up-method:last-child {
            border-bottom: none;
        }
        .bank-list {
            margin-top: 20px;
        }
        .bank-item {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: 0.3s;
        }
        .bank-item:hover {
            background-color: #f1f1f1;
        }
        .bank-logo {
            width: 40px;
            height: 40px;
            margin-right: 15px;
        }
        a{
            text-decoration : none ;
            color : black;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="top-up-container">
            <h3 class="text-center">Top Up</h3>
            <p class="text-center text-muted">Pilih metode top-up yang diinginkan</p>

            <div class="top-up-method">
                <h5><i class="bi bi-shop"></i> Indomaret <span class="badge bg-primary">New</span></h5>
                <p class="text-muted">Top up menggunakan cash di Indomaret</p>
            </div>

            <div class="top-up-method">
                <h5><i class="bi bi-credit-card"></i> ATM</h5>
                <div class="bank-list">
                    <a href="konfirmarsi_top_up.php">
                        <div class="bank-item">
                            <img src="assets/img/bca.png" alt="BCA" class="bank-logo"> BCA
                        </div>
                    </a>
                    <div class="bank-item">
                        <img src="assets/img/mandiri.png" alt="Mandiri" class="bank-logo"> Mandiri
                    </div>
                    <div class="bank-item">
                        <img src="assets/img/bri.png" alt="BRI" class="bank-logo"> BRI
                    </div>
                    <div class="bank-item">
                        <img src="assets/img/bni.png" alt="BNI" class="bank-logo"> BNI
                    </div>
                </div>
            </div>

            <div class="top-up-method">
                <h5><i class="bi bi-phone"></i> Internet / Mobile Banking</h5>
                <div class="bank-list">
                    <a href="konfirmasi_top_up.php">
                        <div class="bank-item">
                            <img src="assets/img/bcam.png" alt="BCA" class="bank-logo"> m-BCA
                        </div>
                    </a>
                    <div class="bank-item">
                        <img src="assets/img/livin.jpg" alt="Mandiri" class="bank-logo"> Livin' by Mandiri
                    </div>
                    <div class="bank-item">
                        <img src="assets/img/brimo.png" alt="BRI" class="bank-logo"> BRI Mobile
                    </div>
                    <div class="bank-item">
                        <img src="assets/img/bnim.png" alt="BNI" class="bank-logo"> BNI Mobile
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>
