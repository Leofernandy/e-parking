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
    <div class="vehicle-container">
        <div class="header text-center fw-bold fs-4 mb-3 text-navy">Kendaraan Saya</div>
        
        <section class="vehicle-card">
            <div class="plate">BK 1823 ABR</div>
            <div class="details">
                <h2>Toyota Agya</h2>
                <p>Putih <span class="status">⭐ Utama</span></p>
                <p class="warning">⚠ Lengkapi data kendaraan anda</p>
            </div>
            <button class="edit-btn" data-bs-toggle="modal" data-bs-target="#editVehicleModal">UBAH</button>
        </section>
        <section class="vehicle-card">
            <div class="plate">BK 1257 AEH</div>
            <div class="details">
                <h2>Mitsubishi Expander</h2>
                <p>Hitam</p>
                <p class="warning">⚠ Lengkapi data kendaraan anda</p>
            </div>
            <button class="edit-btn" data-bs-toggle="modal" data-bs-target="#editVehicleModal">UBAH</button>
        </section>
        <button class="add-btn" data-bs-toggle="modal" data-bs-target="#addVehicleModal">Tambah Kendaraan</button>
    </div>

    <!-- Modal Tambah Kendaraan -->
    <div class="modal fade" id="addVehicleModal" tabindex="-1" aria-labelledby="addVehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVehicleModalLabel">Tambah Kendaraan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-2" placeholder="Nomor Plat Kendaraan">
                    <input type="text" class="form-control mb-2" placeholder="Merek Kendaraan">
                    <input type="text" class="form-control mb-2" placeholder="Warna Kendaraan">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-navy">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kendaraan -->
    <div class="modal fade" id="editVehicleModal" tabindex="-1" aria-labelledby="editVehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editVehicleModalLabel">Edit Kendaraan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-2" value="BK 1223 AEJ">
                    <input type="text" class="form-control mb-2" value="Toyota Agya">
                    <input type="text" class="form-control mb-2" value="Putih">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
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
        const addVehicleButton = document.querySelector("#addVehicleModal .btn-navy");
        const vehicleContainer = document.querySelector(".vehicle-container");
        
        addVehicleButton.addEventListener("click", function() {
            const plateInput = document.querySelector("#addVehicleModal input:nth-child(1)").value;
            const brandInput = document.querySelector("#addVehicleModal input:nth-child(2)").value;
            const colorInput = document.querySelector("#addVehicleModal input:nth-child(3)").value;

            if (plateInput && brandInput && colorInput) {
                const vehicleCard = document.createElement("section");
                vehicleCard.classList.add("vehicle-card");
                vehicleCard.innerHTML = `
                    <div class="plate">${plateInput}</div>
                    <div class="details">
                        <h2>${brandInput}</h2>
                        <p>${colorInput}</p>
                        <p class="warning">⚠ Lengkapi data kendaraan anda</p>
                    </div>
                    <button class="edit-btn" data-bs-toggle="modal" data-bs-target="#editVehicleModal">UBAH</button>
                `;

                vehicleContainer.insertBefore(vehicleCard, document.querySelector(".add-btn"));

                // Reset input fields
                document.querySelector("#addVehicleModal input:nth-child(1)").value = "";
                document.querySelector("#addVehicleModal input:nth-child(2)").value = "";
                document.querySelector("#addVehicleModal input:nth-child(3)").value = "";

                // Tutup modal setelah menambahkan kendaraan
                var modal = bootstrap.Modal.getInstance(document.getElementById('addVehicleModal'));
                modal.hide();
            } else {
                alert("Harap isi semua kolom kendaraan!");
            }
        });
    });
    </script>

</body>
</html>
