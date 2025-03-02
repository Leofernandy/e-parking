<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantuan - Parkeer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-light">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="assets/img/Logobgwhite.png" alt="Parkeer Logo" width="40" class="me-2">
                <span class="text-navy fw-bold fs-3">Parkeer</span>
            </a>
        </div>
    </nav>

    <!-- Bantuan Section -->
    <div class="container-fluid mt-5 px-3">
        <h2 class="text-navy text-center fw-bold mb-4">Bantuan</h2>

        <div class="row justify-content-center">
            <!-- Notifikasi Parkir -->
            <div class="col-md-6">
                <div class="alert alert-danger d-flex align-items-center alert-blink" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-3 me-2 text-danger"></i>
                    <div>
                        <strong>Perhatian!</strong> Waktu parkir Anda tersisa <strong>15 menit</strong>. Segera lakukan perpanjangan!
                    </div>
                </div>
            </div>

            <!-- Reward Parkir -->
            <div class="col-md-6">
                <div class="alert alert-success d-flex align-items-center fade-in" role="alert">
                    <i class="bi bi-gift-fill fs-3 me-2 text-success"></i>
                    <div>
                        Selamat! Anda telah menempuh 10 jam waktu parkir dan mendapatkan 1 jam parkir gratis!
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="dashboard.php" class="btn btn-navy"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
