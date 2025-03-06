<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Parkeer</title>
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
            <img src="assets/img/profilepic.jpg" alt="Foto Profil" class="profile-img me-2">
            <span class="fw-bold text-navy">Fedor Reyes</span>
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
                    <img src="assets/img/mall1.jpg" alt="Mall" class="img-fluid">
                    <h5 class="mt-3 fw-bold" id="nama-mall">Centre Point Mall</h5>
                    <h7>Jalan Jawa, 8, Medan, Indonesia</h7>
                    <p class="text-muted">IDR 5.000/jam | Jarak: 4.87 km</p>
                    <p class="text-muted"></p>
                </div>
                <form class="payment-form mt-3">
                    <div class="mb-2">
                        <label for="kendaraan" class="form-label">Pilih Kendaraan</label>
                        <select class="form-control" id="kendaraan">
                            <option>Mobil</option>
                            <option>Motor</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="plat" class="form-label">Plat Kendaraan</label>
                        <select class="form-control" id="plat">
                            <option>BK 73 SUS</option>
                            <option>BK 1 RI</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="slot-terpilih" class="form-label">Slot Parkir Terpilih</label>
                        <input type="text" class="form-control" id="slot-terpilih" readonly>
                    </div>
                    <div class="mb-2">
                        <label for="waktu-masuk" class="form-label">Waktu Masuk</label>
                        <input type="datetime-local" class="form-control" id="waktu-masuk">
                    </div>
                    <div class="mb-2">
                        <label for="waktu-keluar" class="form-label">Waktu Keluar</label>
                        <input type="datetime-local" class="form-control" id="waktu-keluar">
                    </div>
                    <div class="mb-2">
                        <label for="total-parkir" class="form-label">Total Parkir</label>
                        <input type="text" class="form-control" id="total-parkir" readonly placeholder="Rp 15.000">
                    </div>
                    
                    <div class="mb-2">
                        <label for="pembayaran" class="form-label">Pilih Metode Pembayaran</label>
                        <select class="form-control" id="pembayaran">
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
                <h5 class="text-navy text-center bg-white p-2 rounded shadow-sm">Basement Centre Point Mall</h5>
                <div class="slot-container" id="slot-container">
                    <div class="parking-slot available" id="P1">P1</div>
                    <div class="parking-slot available" id="P2">P2</div>
                    <div class="parking-slot occupied" id="P3">P3</div>
                    <div class="parking-slot available" id="P4">P4</div>
                    <div class="parking-slot occupied" id="P5">P5</div>
                    <div class="parking-slot available" id="P6">P6</div>
                    <div class="parking-slot available" id="P7">P7</div>
                    <div class="parking-slot available" id="P8">P8</div>
                    <div class="parking-slot occupied" id="P9">P9</div>
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const slots = document.querySelectorAll(".parking-slot.available");
        const slotInput = document.getElementById("slot-terpilih");
        const bookButton = document.getElementById("book-button");
        const formInputs = document.querySelectorAll(".payment-form select");
        const menuToggle = document.getElementById("menu-toggle");
        const sidebar = document.getElementById("sidebar");

        // Pilih slot parkir
        slots.forEach(slot => {
            slot.addEventListener("click", function () {
                // Reset semua slot yang sudah dipilih sebelumnya
                slots.forEach(s => s.classList.remove("selected"));
                this.classList.add("selected");
                slotInput.value = this.id;
                checkFormFilled();
            });
        });

        // Periksa apakah semua input telah dipilih
        function checkFormFilled() {
            let allFilled = slotInput.value !== "" &&
                            [...formInputs].every(input => input.value.trim() !== "");
            bookButton.disabled = !allFilled;
        }

        // Event listener untuk semua select input
        formInputs.forEach(input => {
            input.addEventListener("change", checkFormFilled);
        });

        // Toggle Sidebar
        menuToggle.addEventListener("click", function () {
            sidebar.classList.toggle("active");
        });
    });

    
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const bookButton = document.getElementById("book-button");
    const paymentModalElement = document.getElementById("paymentModal");
    const successModalElement = document.getElementById("successModal");

    if (!bookButton || !paymentModalElement || !successModalElement) {
        console.error("❌ Elemen modal atau tombol tidak ditemukan!");
        return;
    }

    const paymentModal = new bootstrap.Modal(paymentModalElement);
    const successModal = new bootstrap.Modal(successModalElement);
    const confirmPayment = document.getElementById("confirm-payment");
    const totalPaymentDisplay = document.getElementById("total-payment");

    bookButton.addEventListener("click", function (event) {
        event.preventDefault();
        console.log("✅ Tombol Book Sekarang ditekan");
        totalPaymentDisplay.innerText = "Rp 15.000"; // Contoh harga
        paymentModal.show();
    });

    confirmPayment.addEventListener("click", function () {
        console.log("✅ Pembayaran dikonfirmasi");
        paymentModal.hide();
        setTimeout(() => {
            successModal.show();
        }, 500);
    });
});
</script>


</body>
</html>
