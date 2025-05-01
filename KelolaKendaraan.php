<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location.href = 'login.php';
    </script>";
    exit();
}

// Koneksi database
try {
    $pdo = new PDO("mysql:host=localhost;dbname=parkeer_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// =====================
// Handle Tambah Kendaraan
if (isset($_POST['add_vehicle'])) {
    $plate = $_POST['plate'];
    $brand = $_POST['brand'];
    $color = $_POST['color'];

    $stmt = $pdo->prepare("INSERT INTO vehicles (user_id, plate, brand, color) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $plate, $brand, $color]);

    echo "<script>
        alert('Kendaraan berhasil ditambahkan!');
        window.location.href = 'KelolaKendaraan.php';
    </script>";
    exit();
}

// =====================
// Handle Edit Kendaraan
if (isset($_POST['edit_vehicle'])) {
    $vehicle_id = $_POST['vehicle_id'];
    $plate = $_POST['plate'];
    $brand = $_POST['brand'];
    $color = $_POST['color'];

    $stmt = $pdo->prepare("UPDATE vehicles SET plate = ?, brand = ?, color = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$plate, $brand, $color, $vehicle_id, $_SESSION['user_id']]);

    echo "<script>
        alert('Kendaraan berhasil diupdate!');
        window.location.href = 'KelolaKendaraan.php';
    </script>";
    exit();
}

// =====================
// Handle Hapus Kendaraan
if (isset($_POST['delete_vehicle'])) {
    $vehicle_id = $_POST['vehicle_id'];

    $stmt = $pdo->prepare("DELETE FROM vehicles WHERE id = ? AND user_id = ?");
    $stmt->execute([$vehicle_id, $_SESSION['user_id']]);

    echo "<script>
        alert('Kendaraan berhasil dihapus!');
        window.location.href = 'KelolaKendaraan.php';
    </script>";
    exit();
}

// =====================
// Handle Set Kendaraan Utama
if (isset($_POST['set_primary'])) {
    $vehicle_id = $_POST['vehicle_id'];

    // Pertama, reset semua kendaraan user jadi bukan utama
    $stmt = $pdo->prepare("UPDATE vehicles SET is_primary = 0 WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);

    // Lalu set kendaraan ini jadi utama
    $stmt = $pdo->prepare("UPDATE vehicles SET is_primary = 1 WHERE id = ? AND user_id = ?");
    $stmt->execute([$vehicle_id, $_SESSION['user_id']]);

    $_SESSION['success'] = "Kendaraan berhasil dijadikan utama!";
    header("Location: KelolaKendaraan.php");
    exit();
}


// Ambil kendaraan user
$stmt = $pdo->prepare("SELECT * FROM vehicles WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



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
        
        .vehicle-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 20px;
            margin-top: 90px;
        }
        .vehicle-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .plate {
            font-size: 18px;
            font-weight: bold;
            background: #2E4A5E;
            color: white;
            padding: 5px 15px;
            border-radius: 5px;
            width: 150px; /* Atur lebar tetap */
            text-align: center; /* Pusatkan teks */
        }
        .details {
            flex-grow: 1;
            margin-left: 15px;
        }
        .details h2 {
            font-size: 20px;
            margin: 0;
            color: #2E4A5E;
        }
        .details p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        .status {
            background: #FFD700;
            color: #2E4A5E;
            font-weight: bold;
            padding: 3px 8px;
            border-radius: 5px;
        }
        .status2 {
            background: #2E4A5E;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .status2:hover {
            background: #243b53;
        }
        .warning {
            color: #D9534F;
            font-weight: bold;
        }
        .edit-btn, .add-btn {
            background: #2E4A5E;
            color: white;
            border: none;
            padding: 15px 15px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 15px;
            font-weight:bold;
        }
        .edit-btn:hover, .add-btn:hover {
            background: #243b53;
        }

        .btn-navy{
            background: #2E4A5E;
            color:white;

        }


        .primary-btn {
            background: #FFD700; /* Warna kuning emas */
            color: #2E4A5E; /* Navy, sama kayak teks di status */
            border: none;
            padding: 15px 15px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
            margin:10px;
        }
        .primary-btn:hover {
            background: #e6c200; /* Sedikit lebih gelap saat hover */
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
    <div class="vehicle-container">
    <div class="header text-center fw-bold fs-4 mb-3 text-navy">Kendaraan Saya</div>

    <?php foreach ($vehicles as $vehicle): ?>
        <section class="vehicle-card">
            <div class="plate"><?php echo htmlspecialchars($vehicle['plate']); ?></div>
            <div class="details">
                <h2><?php echo htmlspecialchars($vehicle['brand']); ?></h2>
                <p><?php echo htmlspecialchars($vehicle['color']); ?>
                    <?php if ($vehicle['is_primary']): ?>
                        <span class="status">⭐ Utama</span>
                    <?php endif; ?>
                </p>
            </div>
            <?php if (!$vehicle['is_primary']): ?>
    <form method="POST" action="KelolaKendaraan.php" style="display:inline;">
        <input type="hidden" name="vehicle_id" value="<?php echo $vehicle['id']; ?>">
        <button type="submit" name="set_primary" class="primary-btn ms-2">JADIKAN UTAMA</button>
    </form>
<?php endif; ?>

            <button class="edit-btn" 
    data-bs-toggle="modal" 
    data-bs-target="#editVehicleModal"
    data-id="<?php echo $vehicle['id']; ?>"
    data-plate="<?php echo htmlspecialchars($vehicle['plate']); ?>"
    data-brand="<?php echo htmlspecialchars($vehicle['brand']); ?>"
    data-color="<?php echo htmlspecialchars($vehicle['color']); ?>"
>UBAH</button>



            <form method="POST" action="KelolaKendaraan.php" onsubmit="return confirm('Yakin hapus kendaraan ini?')">
    <input type="hidden" name="vehicle_id" value="<?php echo $vehicle['id']; ?>">
    <button type="submit" name="delete_vehicle" class="edit-btn btn-danger ms-2" style="background:#D9534F;">HAPUS</button>

</form>

        </section>
    <?php endforeach; ?>

    <button class="add-btn" data-bs-toggle="modal" data-bs-target="#addVehicleModal">Tambah Kendaraan</button>
</div>


    <!-- Modal Tambah Kendaraan -->
<div class="modal fade" id="addVehicleModal" tabindex="-1" aria-labelledby="addVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="KelolaKendaraan.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVehicleModalLabel">Tambah Kendaraan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="plate" class="form-control mb-2" placeholder="Nomor Plat Kendaraan" required>
                    <input type="text" name="brand" class="form-control mb-2" placeholder="Merek Kendaraan" required>
                    <input type="text" name="color" class="form-control mb-2" placeholder="Warna Kendaraan" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" name="add_vehicle" class="btn btn-navy">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Modal Edit Kendaraan -->
<div class="modal fade" id="editVehicleModal" tabindex="-1" aria-labelledby="editVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="KelolaKendaraan.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editVehicleModalLabel">Edit Kendaraan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="vehicle_id" id="edit_vehicle_id">
                    <input type="text" name="plate" id="edit_plate" class="form-control mb-2" placeholder="Nomor Plat Kendaraan" required>
                    <input type="text" name="brand" id="edit_brand" class="form-control mb-2" placeholder="Merek Kendaraan" required>
                    <input type="text" name="color" id="edit_color" class="form-control mb-2" placeholder="Warna Kendaraan" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" name="edit_vehicle" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.edit-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                document.getElementById('edit_plate').value = this.getAttribute('data-plate');
                document.getElementById('edit_brand').value = this.getAttribute('data-brand');
                document.getElementById('edit_color').value = this.getAttribute('data-color');
                document.getElementById('edit_vehicle_id').value = this.getAttribute('data-id');
            });
        });

    });
</script>


</body>
</html>
