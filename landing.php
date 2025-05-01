<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkeer</title>
    <link rel="shortcut icon" href="assets/img/Logobgwhite.png">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%);
            margin: 0;
        }

        .logo {
            width: 350px; /* Sesuaikan ukuran logo */
            opacity: 0;
            animation: fadeEffect 3s ease-in-out;
        }

        @keyframes fadeEffect {
            0% { opacity: 0; }
            50% { opacity: 1; }
            100% { opacity: 0; }
        }
    </style>

    <script>
        // Redirect ke halaman login setelah 3 detik
        setTimeout(function() {
            window.location.href = "landing-page.php"; // Ganti dengan halaman login yang sesuai
        }, 3000);
    </script>
</head>
<body>
    <img src="assets/img/Logobgwhite.png" alt="Parkeer Logo" class="logo">
</body>
</html>
