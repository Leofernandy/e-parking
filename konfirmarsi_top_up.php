<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up - Parkeer</title>
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
        <a href="reservasi.php">Reservasi</a>
        <a href="riwayat.php">Riwayat Pemesanan</a>
        <a href="dompet.php">Dompet</a>
        <a href="PengaturanAkun.php">Akun</a>
        <a href="bantuan.php">Notifikasi</a>
    </div>
    
    <!-- Content -->
    <script>
        function loadPaymentMethod() {
            const urlParams = new URLSearchParams(window.location.search);
            const method = urlParams.get('method');
            document.getElementById('paymentMethod').textContent = method;
        }

        function validateAmount() {
            let amount = document.getElementById("amount").value;
            let errorText = document.getElementById("errorText");
            let submitBtn = document.getElementById("submitBtn");

            if (amount === "" || isNaN(amount) || amount < 10000) {
                errorText.textContent = "Minimal top-up Rp10.000";
                submitBtn.disabled = true;
            } else {
                errorText.textContent = "";
                submitBtn.disabled = false;
            }
        }

        function showConfirmationPopup() {
            let amount = document.getElementById("amount").value;
            let method = document.getElementById("paymentMethod").textContent;

            document.getElementById("popupMethod").textContent = method;
            document.getElementById("popupAmount").textContent = "Rp" + parseInt(amount).toLocaleString();

            let popup = new bootstrap.Modal(document.getElementById("confirmationModal"));
            popup.show();
        }
    </script>
    <style>
        body { background-color: #f8f9fa; }
        .confirm-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .error-text { color: red; font-size: 14px; margin-top: 5px; }
        .container{
            margin-top : 100px ;
        }
    </style>
</head>
<body onload="loadPaymentMethod()">

    <div class="container">
        <div class="confirm-container">
            <h3>Konfirmasi Pembayaran</h3>
            <p>Anda memilih metode:</p>
            <h4 id="paymentMethod"></h4>

            
            <div class="mt-3">
                <label for="amount" class="form-label">Masukkan Nominal:</label>
                <input type="number" id="amount" class="form-control" placeholder="Min. Rp10.000" oninput="validateAmount()">
                <span id="errorText" class="error-text"></span>
            </div>

            <p class="mt-3">Silakan lanjutkan ke pembayaran.</p>
            
            
            <button id="submitBtn" class="btn btn-primary" disabled onclick="showConfirmationPopup()">Lanjutkan</button>
            <a href="topup.php" class="btn btn-secondary">Batal</a>
        </div>
    </div>

    
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Akhir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Metode Pembayaran: <strong id="popupMethod"></strong></p>
                    <p>Nominal: <strong id="popupAmount"></strong></p>
                    <p>Pastikan data sudah benar sebelum melanjutkan.</p>
                </div>
                <div class="modal-footer">
                    <a href="success.php" class="btn btn-success">Konfirmasi</a>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>
