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
        
        .container {
            padding-top: 80px;
            max-width: 1000px;
            margin: 20px auto;
            display: flex;
            gap: 20px;
        }

        .wallet-section {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            flex: 1;
        }
        .wallet-header {
            background: #2E4A5E;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: left;
            position: relative;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .wallet-header .settings {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 20px;
        }
        .wallet-balance {
            font-size: 14px;
            font-weight: 600;
            margin-top: 4px;
        }

        #saldo{
            font-size: 36px;
            font-weight: bold;
        }
        .btn-topup {
            background: white;
            color: #2E4A5E;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            margin-top: 30px;
            font-weight: bold;
        }
        .transactions-section {
            flex: 2;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .transaction-list {
            max-height: 500px;
            overflow-y: auto;
        }
        .transaction-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            font-weight: 600;
            border-bottom: 1px solid #ddd;
            font-size: 16px;
            flex-direction: column;
        }
        .transaction-item span.time {
            font-size: 12px;
            color: rgb(180, 180, 180);
            margin-top: -18px;
        }
        #negative {
            color: red;
            float: right;
            text-align: right;
        }
        #positive {
            color: green;
            text-align: right;
        }

        #pilihan{
            border: 1px solid rgba(180, 180, 180, 0.396);
            border-radius: 8px;
            padding: 5px;
        }

        .promo{
            margin: 20px 0px
        }
        
        input{
            margin-top: 4px;
            margin-bottom: 10px;
            padding: 6px;
            width: 100%;
            border-radius: 6px;
            border: 1px solid rgba(180, 180, 180, 0.396);
        }

        .voucher{
            padding: 8px;
            border: 1px solid rgba(180, 180, 180, 0.396);
            color:#2e4a5ecd;
            border-radius: 6px;
            padding-left: 15px;
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 5px;
        }
        
        .use{
            float: right;
            font-weight: 600;
        }

        input::placeholder {
            color: rgba(128, 128, 128, 0.56); 
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
    <div class="container">
        <div class="wallet-section">
            <div class="wallet-header">
                <span>Saldo</span>
                <div class="wallet-balance">Rp <span id="saldo">150.000</span></div>
                <button class="btn-topup" onclick="topUp()">Top Up</button>
            </div>
            <div class="promo">
                <span>Promo</span><br>
                <input type="text" name="kodepromo" placeholder="Masukkan kode promo"><br>
                <div class="voucher">Voucher 10k
                    <div class="use">Use</div>
                </div>
                <div class="voucher">Voucher 5k
                    <div class="use">Use</div>
                </div>
            </div>
        </div>
        
        <div class="transactions-section">
            <h3>Riwayat Transaksi</h5>
            <select name="pilihan" id ="pilihan">
                <option value="Semua Transaksi">Semua Transaksi</option>
                <option value="7 hari">7 Hari Terakhir</option>
                <option value="30 hari">30 Hari Terakhir</option>
            </select><br>
            <div class="transaction-list">
                <div class="transaction-item">
                    <span>Pembayaran</span>
                    <span id = "negative">- Rp 10.000</span>
                    <span class="time">12 Okt 2024, 12:00 WIB</span>
                </div>
                <div class="transaction-item">
                    <span>Top Up</span>
                    <span id = "positive">+ Rp 50.000</span>
                    <span class="time">1 Okt 2024, 21:08 WIB</span>
                </div>
                <div class="transaction-item">
                    <span>Pembayaran</span>
                    <span id="negative">- Rp 20.000</span>
                    <span class="time">21 Sep 2024, 17:53 WIB</span>
                </div>
                <div class="transaction-item">
                    <span>Pembayaran</span>
                    <span id="negative">- Rp 15.000</span>
                    <span class="time">16 Sep 2024, 20:10 WIB</span>
                </div>
                <div class="transaction-item">
                    <span>Top Up</span>
                    <span id="positive">+ Rp 100.000</span>
                    <span class="time">7 Sep 2024, 14:44 WIB</span>
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
