<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'config.php';

$nama_mall = $_POST['nama_mall'] ?? '';
$alamat_mall = $_POST['alamat_mall'] ?? '';
$gambar_mall = $_POST['gambar_mall'] ?? '';
$harga_per_jam = $_POST['harga_per_jam'] ?? 0;
$mall_id = $_POST['mall_id'] ?? 1;


if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit();
}


$user_id = $_SESSION['user_id'];




// Proses booking ketika konfirmasi pembayaran
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['proses_booking'])) {
    $mall_id = $_POST['mall_id'];
    $vehicle_id = $_POST['vehicle_id'];
    $parking_slot_id = $_POST['parking_slot_id'];
    $waktu_masuk = $_POST['waktu_masuk'];
    $waktu_keluar = $_POST['waktu_keluar'];
    $biaya = $_POST['biaya'];
    $metode_pembayaran = $_POST['metode_pembayaran'];

    $stmt = $pdo->prepare("SELECT saldo FROM users WHERE id = :id");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch();

    if ($user['saldo'] < $biaya) {
        echo "<script>alert('Saldo tidak mencukupi. Silakan top up.'); window.location.href='dompet.php';</script>";
        exit();
    }

    $durasi = (strtotime($waktu_keluar) - strtotime($waktu_masuk)) / 60;
    $booking_code = strtoupper(uniqid('BK'));

    $stmt = $pdo->prepare("INSERT INTO reservations (user_id, vehicle_id, mall_id, parking_slot_id, booking_code, waktu_masuk, waktu_keluar, durasi, biaya, metode_pembayaran, qr_code_path, status) VALUES (:user_id, :vehicle_id, :mall_id, :parking_slot_id, :booking_code, :waktu_masuk, :waktu_keluar, :durasi, :biaya, :metode_pembayaran, :qr_code_path, :status)");
    $stmt->execute([
        'user_id' => $user_id,
        'vehicle_id' => $vehicle_id,
        'mall_id' => $mall_id,
        'parking_slot_id' => $parking_slot_id,
        'booking_code' => $booking_code,
        'waktu_masuk' => $waktu_masuk,
        'waktu_keluar' => $waktu_keluar,
        'durasi' => $durasi,
        'biaya' => $biaya,
        'metode_pembayaran' => $metode_pembayaran,
        'qr_code_path' => '-',
        'status' => 'pending'
    ]);

    $stmt = $pdo->prepare("UPDATE users SET saldo = saldo - :biaya WHERE id = :id");
    $stmt->execute(['biaya' => $biaya, 'id' => $user_id]);

    $stmt = $pdo->prepare("UPDATE parking_slots SET status = 'booked' WHERE id = :id");
    $stmt->execute(['id' => $parking_slot_id]);

    $keterangan = "Booking di " . ($mall_id == 1 ? 'Centre Point Mall' : ($mall_id == 2 ? 'Sun Plaza' : 'DeliPark Mall'));

    $stmt = $pdo->prepare("INSERT INTO transaction_history (user_id, amount, keterangan, created_at) VALUES (:user_id, :amount, :keterangan, NOW())");
    $stmt->execute([
        'user_id' => $user_id,
        'amount' => $biaya,
        'keterangan' => $keterangan
    ]);

    echo "<script>alert('Reservasi Berhasil!'); window.location.href='riwayat.php';</script>";
    exit();
}

?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Parkeer</title>
    <link rel="shortcut icon" href="assets/img/Logobgwhite.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body { background: #f0f4f8; margin: 0; padding: 0; }
        .mall-card, .payment-form { background: white; padding: 15px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .mall-card img { width: 100%; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 10px; }
        .btn-navy { background: #2E4A5E;
    border: none;
    transition:  0.3s;
    color: white;
    border-radius: 10px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
height:40px; }
        .btn-navy:hover { background: #243b53; }
        .parking-slot { width: 180px; height: 250px; border: 4px solid #2E4A5E; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; cursor: pointer; margin: 10px; border-top: none; border-radius: 5px; }
        .available { background-color: #243b53; color: white; }
        .occupied { background-color: rgb(255, 108, 108); color: white; cursor: not-allowed; }
        .selected { background-color: rgb(27, 105, 239) ; color: white; }
        .profile-img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
        .sidebar { width: 250px; position: fixed; height: 100%; background: #2E4A5E; padding-top: 20px; left: -250px; transition: left 0.3s; }
        .sidebar.active { left: 0; }
        .sidebar a { padding: 10px 15px; display: block; color: white; text-decoration: none; }
        .sidebar a:hover { background: #243b53; }
        .slot-container { display: flex; flex-wrap: wrap; justify-content: center; max-width: 1000px; margin: auto; gap: 10px; font-size:30px; text-shadow:0px 0px 5px #243b53; color:transparent;}
        #warning {
    font-size: 12px;
    padding-top: 5px;
    padding-left: 2px;
}

        
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-header d-flex justify-content-between px-3">
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
    
    <div class="sidebar" id="sidebar">
        <a href="reservasi.php">Reservasi</a>
        <a href="riwayat.php">Riwayat Pemesanan</a>
        <a href="dompet.php">Dompet</a>
        <a href="PengaturanAkun.php">Akun</a>
        <a href="bantuan.php">Notifikasi</a>
    </div>
    
    <div class="container mt-4">
        <h2 class="text-navy">Booking Parkir</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="mall-card">
                    <img src="<?= htmlspecialchars($gambar_mall); ?>" alt="Mall" class="img-fluid">

                    <h5 class="mt-3 fw-bold" id="nama-mall"><?php echo htmlspecialchars($nama_mall); ?></h5>
                    <h7><?php echo htmlspecialchars($alamat_mall); ?></h7>
                    <p class="text-muted">IDR <?php echo number_format($harga_per_jam, 0, ',', '.'); ?>/jam</p>

                    <p class="text-muted"></p>
                </div>
                
                <form class="payment-form mt-3" method="POST" action="bayar.php" id="bookingForm">
                <input type="hidden" id="parking_slot_id" name="parking_slot_id">
                <input type="hidden" id="input-biaya" name="biaya">
                <input type="hidden" name="mall_id" value="<?= htmlspecialchars($mall_id); ?>">
                <input type="hidden" name="proses_booking" value="1">

                    <div class="mb-2">
                        <label for="kendaraan" class="form-label">Pilih Kendaraan</label>
                        <select class="form-control" id="kendaraan" name="vehicle_id" required>
                            <?php
                            $stmt = $pdo->prepare("SELECT id, plate, brand FROM vehicles WHERE user_id = :user_id");
                            $stmt->execute(['user_id' => $_SESSION['user_id']]);
                            $vehicles = $stmt->fetchAll();
                            foreach ($vehicles as $vehicle) {
                                echo "<option value='{$vehicle['id']}'>{$vehicle['plate']} - {$vehicle['brand']}</option>";
                            }
                            ?>
                        </select>

                    </div>
                    <div class="mb-2">
                        <label for="slot-terpilih" class="form-label">Slot Parkir Terpilih</label>
                        <input type="text" id="slot-terpilih" class="form-control" readonly>
                    </div>
                    <div class="mb-2">
                        <label for="waktu-masuk" class="form-label">Waktu Masuk</label>
                        <input type="datetime-local" class="form-control" id="waktu-masuk" name="waktu_masuk" required>
                    </div>
                    <div class="mb-2">
                        <label for="waktu-keluar" class="form-label">Waktu Keluar</label>
                        <input type="datetime-local" class="form-control" id="waktu-keluar" name="waktu_keluar" required>
                    </div>
                    <div class="mb-2">
                        <label for="total-parkir" class="form-label">Total Parkir</label>
                        <input type="text" class="form-control" id="total-parkir" readonly placeholder="Rp 15.000">
                    </div>
                    
                    <div class="mb-2">
                        <label for="pembayaran" class="form-label">Pilih Metode Pembayaran</label>
                        <select class="form-control" id="pembayaran" name="metode_pembayaran" required>
                            <option>Dompet Parkeer</option>
                            <option>OVO</option>
                            <option>Gopay</option>
                            <option>Transfer Bank</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn-navy w-100" id="book-button" disabled>Book Sekarang</button>
                    <p id="warning">Sebelum Memesan, <span class="text-danger">Baca Informasi Lengkap Peraturan Reservasi</span></p>
                </form>
            </div>
            <div class="col-md-6">
                <h5 class="text-navy text-center bg-white p-2 rounded shadow-sm"><?= htmlspecialchars($nama_mall); ?></h5>
                <div class="slot-container" id="slot-container">
                    
                <?php
                $mall_id = $_POST['mall_id'] ?? 0; // default ke 1 kalau belum ada

                if ($mall_id == 1) {
                    $slotCodes = ['CP-P1', 'CP-P2', 'CP-P3', 'CP-P4', 'CP-P5', 'CP-P6', 'CP-P7', 'CP-P8', 'CP-P9'];
                } elseif ($mall_id == 2) {
                    $slotCodes = ['SP-P1', 'SP-P2', 'SP-P3', 'SP-P4', 'SP-P5', 'SP-P6', 'SP-P7', 'SP-P8', 'SP-P9'];
                } elseif ($mall_id == 3) {
                    $slotCodes = ['DP-P1', 'DP-P2', 'DP-P3', 'DP-P4', 'DP-P5', 'DP-P6', 'DP-P7', 'DP-P8', 'DP-P9'];
                } else {
                    $slotCodes = []; // Kalau mall belum diatur
                }
                

                foreach ($slotCodes as $code) {
                    $stmt = $pdo->prepare("SELECT id, status FROM parking_slots WHERE slot_code = :slot_code AND mall_id = :mall_id");
                    $stmt->execute(['slot_code' => $code, 'mall_id' => $mall_id]);
                    $slot = $stmt->fetch();

                    if ($slot) {
                        $class = $slot['status'] === 'available' ? 'available' : 'occupied';
                        echo "<div class='parking-slot {$class}' data-id='{$slot['id']}'>" . htmlspecialchars($code) . "</div>";
                    } else {
                        echo "<div class='parking-slot occupied'>" . htmlspecialchars($code) . "</div>"; // Default kalau ga ketemu
                    }
                }
                ?>
                </div>

            </div>
        </div>
    </div>

<!-- Modal Konfirmasi Pembayaran -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Konfirmasi Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin melakukan pembayaran sebesar <strong id="total-payment">Rp 0</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-navy" id="confirm-payment">Bayar Sekarang</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pembayaran Berhasil -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Pembayaran Berhasil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Terima kasih! Pembayaran Anda telah berhasil.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-navy" onclick="window.location.href='riwayat.php'">OK</button>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const waktuMasuk = document.getElementById("waktu-masuk");
        const waktuKeluar = document.getElementById("waktu-keluar");
        const totalParkir = document.getElementById("total-parkir");

        // Ambil harga per jam dari PHP
        const hargaPerJam = <?= $harga_per_jam; ?>;

        function hitungTotalParkir() {
            const masuk = new Date(waktuMasuk.value);
            const keluar = new Date(waktuKeluar.value);

            if (masuk && keluar && keluar > masuk) {
                const durasiMs = keluar - masuk; // dalam milidetik
                const durasiJam = Math.ceil(durasiMs / (1000 * 60 * 60)); // bulatkan ke atas

                const totalBiaya = durasiJam * hargaPerJam;

                totalParkir.value = "Rp " + totalBiaya.toLocaleString('id-ID');

                // Set ke input hidden supaya dikirim saat submit
                document.getElementById("input-biaya").value = totalBiaya;
            } else {
                totalParkir.value = "";
                document.getElementById("input-biaya").value = "";
            }
        }


        waktuMasuk.addEventListener("change", hitungTotalParkir);
        waktuKeluar.addEventListener("change", hitungTotalParkir);
    });
    </script>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
    const slots = document.querySelectorAll(".parking-slot.available");
    const slotInput = document.getElementById("slot-terpilih");
    const parkingSlotIdInput = document.getElementById("parking_slot_id");
    const bookButton = document.getElementById("book-button");
    const formInputs = document.querySelectorAll(".payment-form select");

    slots.forEach(slot => {
        slot.addEventListener("click", function () {
            slots.forEach(s => s.classList.remove("selected"));
            this.classList.add("selected");
            slotInput.value = this.innerText;  // Nama slot ditampilkan
            parkingSlotIdInput.value = this.getAttribute('data-id'); // ID slot dikirim
            checkFormFilled();
        });
    });

    function checkFormFilled() {
        let allFilled = slotInput.value !== "" &&
                        [...formInputs].every(input => input.value.trim() !== "");
        bookButton.disabled = !allFilled;
    }

    formInputs.forEach(input => {
        input.addEventListener("change", checkFormFilled);
    });
});


    
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const bookButton = document.getElementById("book-button");
    const confirmPayment = document.getElementById("confirm-payment");
    const bookingForm = document.getElementById("bookingForm");
    const paymentModal = new bootstrap.Modal(document.getElementById("paymentModal"));
    const successModal = new bootstrap.Modal(document.getElementById("successModal"));

    const hargaPerJam = <?= $harga_per_jam; ?>;
    const waktuMasuk = document.getElementById("waktu-masuk");
    const waktuKeluar = document.getElementById("waktu-keluar");
    const totalPaymentDisplay = document.getElementById("total-payment");

    if (!bookButton || !paymentModalElement || !successModalElement) {
        console.error("❌ Elemen modal atau tombol tidak ditemukan!");
        return;
    }

    const paymentModal = new bootstrap.Modal(paymentModalElement);
    const successModal = new bootstrap.Modal(successModalElement);
    const confirmPayment = document.getElementById("confirm-payment");

    bookButton.addEventListener("click", function (event) {
        event.preventDefault();
        paymentModal.show();
    });

        // Hitung ulang total harga ketika klik Book Sekarang
        const masuk = new Date(waktuMasuk.value);
        const keluar = new Date(waktuKeluar.value);

        if (masuk && keluar && keluar > masuk) {
            const durasiMs = keluar - masuk;
            const durasiJam = Math.ceil(durasiMs / (1000 * 60 * 60));
            const totalBiaya = durasiJam * hargaPerJam;

            totalPaymentDisplay.innerText = "Rp " + totalBiaya.toLocaleString('id-ID');
        } else {
            totalPaymentDisplay.innerText = "Rp 0";
        }

        paymentModal.show();
    });

    confirmPayment.addEventListener("click", function () {
        paymentModal.hide();

        setTimeout(() => {
            bookingForm.submit(); // ⬅️ SUBMIT form sekarang!
        }, 300);
    });

</script>


</body>
</html>
