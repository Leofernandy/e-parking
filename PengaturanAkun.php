<?php
session_start();
try {
    $pdo = new PDO("mysql:host=localhost;dbname=parkeer_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location.href = 'login.php';
    </script>";
    exit();
}
$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT nama, email, no_hp, foto_profile FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Saya - Parkeer</title>
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
        .container {
            margin-top: 90px;
        }
        .profile-section {
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .profile-section p {
            margin-bottom: 8px;
            font-size: 16px;
        }
        .list-group-item {
            padding: 20px;
            font-size: 17px;
        }
        .btn-signout {
            background: #d9534f;
            color: white;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            width: 100%;
            text-align: center;
            margin-bottom: 40px;
            text-decoration: none;
        }
        .btn-signout:hover {
            background: #c9302c;
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
            z-index:1050;
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
<!-- Modal Edit Profile -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="update_profile.php" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProfileModalLabel">Edit Akun Saya</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="nama" class="form-label">Nama</label>
          <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($user['nama']); ?>" required>
        </div>
        <div class="mb-3">
          <label for="no_hp" class="form-label">No HP</label>
          <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= htmlspecialchars($user['no_hp']); ?>" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="password_baru" class="form-label">Password Baru (opsional)</label>
            <input type="password" class="form-control" id="password_baru" name="password_baru">
        </div>

        <div class="mb-3">
          <label for="foto_profile" class="form-label">Foto Profile (optional)</label>
          <input type="file" class="form-control" id="foto_profile" name="foto_profile">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

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
    <div class="container">
        <div class="header text-center fw-bold fs-4 mb-3 text-navy">Akun Saya</div>
        <div class="profile-section d-flex align-items-center ml-2 p-15">
        <img src="<?= $user['foto_profile'] ? $user['foto_profile'] : 'assets/img/profilepic.jpg'; ?>" 
        alt="Foto Profil" class="profile-img me-4" style="width: 80px; height: 80px; margin-left: 20px; object-fit: cover; border-radius: 50%;">


            <div class="ms-2">
                <p class="fw-bold fs-5"><?= htmlspecialchars($user['nama']); ?></p>
                <p class="text-muted fs-8"><?= htmlspecialchars($user['no_hp']); ?></p>
                <p class="text-muted fs-8"><?= htmlspecialchars($user['email']); ?></p>
            </div>
            <a href="#" class="ms-auto text-navy fs-4" data-bs-toggle="modal" data-bs-target="#editProfileModal">
    <i class="bi bi-pencil-square"></i>
</a>

        </div>
        
        <div class="menu-section mt-4">
            <h5 class="text-secondary">Pengaturan & Keamanan</h5>
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action"><i class="bi bi-shield-lock p-2"></i> Atur Keamanan</a>
                <a href="KelolaKendaraan.php" class="list-group-item list-group-item-action "><i class="bi bi-car-front p-2"></i> Kelola Kendaraan</a>
                <a href="#" class="list-group-item list-group-item-action"><i class="bi bi-translate p-2"></i> Pilih Bahasa</a>
                <a href="#" class="list-group-item list-group-item-action"><i class="bi bi-gift p-2"></i> Bagikan & Dapatkan Bonus</a>
            </div>
        </div>
    
        <div class="menu-section mt-4 mb-4">
            <h5 class="text-secondary">Bantuan & Informasi</h5>
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action"><i class="bi bi-book p-2"></i>  Panduan Pengguna</a>
                <a href="#" class="list-group-item list-group-item-action"><i class="bi bi-geo-alt p-2"></i> Lokasi Favorit Saya</a>
                <a href="bantuan.php" class="list-group-item list-group-item-action"><i class="bi bi-question-circle p-2"></i> Pusat Bantuan</a>
                <a href="#" class="list-group-item list-group-item-action"><i class="bi bi-chat-dots p-2"></i> Hubungi Customer Service</a>
            </div>
        </div>
    
        <a href="logout.php" class="btn-signout">Sign Out</a>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>
