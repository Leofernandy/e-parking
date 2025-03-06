<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Parkeer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 10px 20px;
            display: block;
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
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
<body class="bg-light">
    <div class="sidebar">
        <a href="dashboard.php"><i class="bi bi-house-door-fill"></i> Dashboard</a>
        <a href="bantuan.php"><i class="bi bi-question-circle-fill"></i> Bantuan</a>
    </div>

    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="assets/img/Logobgwhite.png" alt="Parkeer Logo" width="40" class="me-2">
                    <span class="text-navy fw-bold fs-3">Parkeer</span>
                </a>
                <div class="ms-auto">
                    <img src="assets/img/profile.jpg" alt="Profile" class="profile-pic">
                </div>
            </div>
        </nav>

        <div class="container-fluid mt-5 px-3">
            <h2 class="text-navy text-center fw-bold mb-4">Notifikasi</h2>
            <div class="row justify-content-center px-3">
                <div class="col-12">
                    <div class="card card-custom card-danger">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill fs-3 text-danger me-3"></i>
                            <div>
                                <h5 class="fw-bold text-danger">Perhatian!</h5>
                                <p>Waktu parkir Anda tersisa <strong>15 menit</strong>. Segera lakukan perpanjangan!</p>
                            </div>
                        </div>
                        <span class="timer text-danger" id="sisaWaktu">14:23:02</span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-custom card-success">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-gift-fill fs-3 text-success me-3"></i>
                            <div>
                                <h5 class="fw-bold text-success">Gratis Parkir!</h5>
                                <p>Tempuh 10 jam waktu parkir dan mendapatkan 1 jam parkir gratis!</p>
                            </div>
                        </div>
                        <span class="timer text-success" id="waktuReward">02:30:15</span>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="dashboard.php" class="btn btn-navy"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
            </div>
        </div>
    </div>

    <script>
        function updateTimers() {
            let sisaWaktu = document.getElementById("sisaWaktu");
            let waktuReward = document.getElementById("waktuReward");
            
            let now = new Date();
            let parkirHabis = new Date(now.getTime() + 14 * 60 * 1000 + 23 * 1000);
            let rewardTercapai = new Date(now.getTime() + 2 * 60 * 60 * 1000 + 30 * 60 * 1000 + 15 * 1000);
            
            function updateCountdown() {
                let now = new Date();
                let sisaMs = parkirHabis - now;
                let rewardMs = rewardTercapai - now;
                
                if (sisaMs > 0) {
                    let sisaJam = Math.floor(sisaMs / (1000 * 60 * 60));
                    let sisaMenit = Math.floor((sisaMs % (1000 * 60 * 60)) / (1000 * 60));
                    let sisaDetik = Math.floor((sisaMs % (1000 * 60)) / 1000);
                    sisaWaktu.innerText = `${sisaJam.toString().padStart(2, '0')}:${sisaMenit.toString().padStart(2, '0')}:${sisaDetik.toString().padStart(2, '0')}`;
                }
                
                if (rewardMs > 0) {
                    let rewardJam = Math.floor(rewardMs / (1000 * 60 * 60));
                    let rewardMenit = Math.floor((rewardMs % (1000 * 60 * 60)) / (1000 * 60));
                    let rewardDetik = Math.floor((rewardMs % (1000 * 60)) / 1000);
                    waktuReward.innerText = `${rewardJam.toString().padStart(2, '0')}:${rewardMenit.toString().padStart(2, '0')}:${rewardDetik.toString().padStart(2, '0')}`;
                }
            }
            
            setInterval(updateCountdown, 1000);
        }
        updateTimers();
    </script>
</body>
</html>
