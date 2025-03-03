<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="shortcut icon" href="assets/img/Logobgwhite.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkeer - Landing Page</title>
    <style>
        :root {
            --primary: #2E4A5E;
            --secondary: #d9e2ec;
            --accent: #f57c00;
            --light: #f5f5f5;
            --dark: #212121;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            color: var(--dark);
            line-height: 1.6;
        }
        
        /* Header */
        header {
            background-color: white;
            box-shadow: var(--shadow);
            position: fixed;
            width: 100%;
            z-index: 1000;
        }
        
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 5%;
            margin: 0 auto;
            max-width: 1400px;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }
        
        .logo span {
            color: var(--accent);
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: var(--primary);
        }
        
        .cta-button {
            background-color: var(--primary);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .cta-button:hover {
            background-color: var(--secondary);
        }
        
        /* Hero Section */
        .hero {
            /* background: linear-gradient(135deg, var(--secondary), var(--primary)); */
            background: var(--primary);
            color: white;
            padding-left: 2rem;
            padding-top: 4rem;
            margin-top: 0;
            margin-right: 0;
        }
        
        .hero-container {
            display: flex;
            max-width: 1400px;
            margin: 0 auto;
            align-items: center;
            gap: 2rem;
            padding-left: 4rem;
        }
        
        .hero-content {
            flex: 1;
        }
        
        .hero-image {
            flex: 1;
            position: relative;
            height: 100%;
            min-height: 500px; 
            width: 50%; 
        }
        
        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            box-shadow: var(--shadow);
            position: absolute;
            top: 0;
            right: 0;
        }
        @media (max-width: 768px) {
            .hero-container {
                flex-direction: column;
            }
            
            .hero-image {
                width: 100%;
                min-height: 300px;
                margin-top: 2rem;
                position: relative;
            }
            
            .hero-image img {
                position: relative;
            }
        }
                
        .hero h1 {
            font-size: 2.5rem;
            line-height: 1.2;
            margin-bottom: 1rem;
        }
        
        .hero p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1rem;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s;
            display: inline-block;
        }
        
        .btn-primary:hover {
            background-color: #e65100;
        }
        
        .btn-secondary {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s;
            display: inline-block;
        }
        
        .btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }
        
        /* Features */
        .features {
            padding: 4rem 5%;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .section-title h2 {
            font-size: 2rem;
            color: var(--dark);
            position: relative;
            display: inline-block;
            padding-bottom: 0.5rem;
        }
        
        .section-title h2::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--primary);
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .feature-card {
            background-color: white;
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            box-shadow: var(--shadow);
            transition: transform 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        .feature-card h3 {
            margin-bottom: 1rem;
            color: var(--dark);
        }
        
        /* How it works */
        .how-it-works {
            background-color: var(--light);
            padding: 4rem 5%;
        }
        
        .steps-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .steps {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            text-align: center;
            position: relative;
            padding: 0 1rem;
        }
        
        .step:not(:last-child)::after {
            content: "";
            position: absolute;
            top: 40px;
            right: -30px;
            width: 60px;
            height: 2px;
            background-color: var(--primary);
        }
        
        .step-number {
            background-color: var(--primary);
            color: white;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }
        
        .step h3 {
            margin-bottom: 0.5rem;
            color: var(--dark);
        }
        
        /* Testimonials */
        .testimonials {
            padding: 4rem 5%;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .testimonial-card {
            background-color: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: var(--shadow);
        }
        
        .testimonial-content {
            margin-bottom: 1.5rem;
            font-style: italic;
            position: relative;
        }
        
        .testimonial-content::before {
            content: "";
            font-size: 4rem;
            position: absolute;
            top: -20px;
            left: -15px;
            color: rgba(0, 0, 0, 0.1);
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
        }
        
        .author-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 1rem;
            overflow: hidden;
        }
        
        .author-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .author-info h4 {
            margin-bottom: 0.2rem;
        }
        
        .author-info p {
            color: #666;
            font-size: 0.9rem;
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(360deg, var(--secondary), var(--primary));
            color: white;
            padding: 4rem 5%;
            text-align: center;
        }
        
        .cta-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .cta-section h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .cta-section p {
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .app-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .app-button {
            display: flex;
            align-items: center;
            background-color: #000;
            color: white;
            padding: 0.7rem 1.5rem;
            border-radius: 10px;
            text-decoration: none;
        }
        
        .app-button i {
            font-size: 1.8rem;
            margin-right: 0.5rem;
        }
        
        .app-button-text {
            text-align: left;
        }
        
        .app-button-text small {
            display: block;
            font-size: 0.7rem;
            opacity: 0.8;
        }
        
        .app-button-text span {
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        /* Footer */
        footer {
            background-color: var(--dark);
            color: white;
            padding: 4rem 5% 2rem;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }
        
        .footer-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
            display: inline-block;
        }
        
        .footer-about p {
            opacity: 0.8;
            margin-bottom: 1.5rem;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
        }
        
        .social-icon {
            background-color: rgb(255, 255, 255);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s;
        }
        
        .social-icon:hover {
            background-color: var(--primary);
        }
        
        .footer-links h3 {
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .footer-links h3::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 30px;
            height: 2px;
            background-color: var(--accent);
        }
        
        .footer-links ul {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 0.8rem;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: var(--accent);
        }
        
        .copyright {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.7;
            font-size: 0.9rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-container {
                flex-direction: column;
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            .steps {
                flex-direction: column;
                gap: 2rem;
            }
            
            .step:not(:last-child)::after {
                display: none;
            }
            
            .app-buttons {
                flex-direction: column;
                align-items: center;
            }
        }

        img{
            width: 50px;  /* Ubah ukuran sesuai kebutuhan */
            height: 50px;  /* Menjaga aspek rasio */
        }

        .lp{
            width: 900px;
            height: 400px;
            margin: 0;
            padding: 0;
        }
        #features, #how, #testimonials{
            padding-top: 6rem;
        }
        .bif{
            color: var(--primary);
        }

    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar">
            <div class="logo-container">
                <img src="assets/img/Logobgwhite.png" alt="logo">
                <a href="#" class="logo">Parkeer</a>
            </div>
            <div class="nav-links">
                <a href="#features">Fitur</a>
                <a href="#how">Cara Kerja</a>
                <a href="#testimonials">Testimoni</a>
                <a href="#contact">Kontak</a>
            </div>
            <a href="#" class="cta-button">Login</a>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1>Solusi Parkir Cerdas untuk Era Digital</h1>
                <p>Kelola parkir kendaraan Anda secara efisien dengan Parkeer. Platform manajemen parkir terpadu yang menggabungkan teknologi terdepan untuk pengalaman parkir tanpa hambatan.</p>
                <div class="hero-buttons">
                    <a href="#" class="btn-secondary">Coba Gratis</a>
                    <a href="#" class="btn-secondary">Pelajari Lebih Lanjut</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="assets/img/lpimg.png" class="lp" alt="Parkeer App Dashboard">
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features" id="features">
        <div class="section-title">
            <h2>Fitur Unggulan</h2>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🔍</div>
                <h3>Pencarian Tempat Parkir</h3>
                <p>Temukan tempat parkir yang tersedia dengan cepat dan mudah melalui aplikasi kami.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⏱️</div>
                <h3>Reservasi Online</h3>
                <p>Pesan tempat parkir Anda sebelum tiba untuk menghindari kerepotan mencari tempat parkir.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💳</div>
                <h3>Pembayaran Digital</h3>
                <p>Bayar biaya parkir dengan mudah melalui berbagai metode pembayaran digital tanpa perlu uang tunai.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Analisis & Laporan</h3>
                <p>Dapatkan wawasan mendalam tentang penggunaan area parkir Anda melalui dashboard analitik yang komprehensif.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🛡️</div>
                <h3>Keamanan Terjamin</h3>
                <p>Sistem pengawasan terintegrasi yang memastikan keamanan kendaraan selama parkir.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h3>Aplikasi Mobile</h3>
                <p>Kelola semua kebutuhan parkir Anda dari smartphone dengan aplikasi yang intuitif.</p>
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section class="how-it-works" id="how">
        <div class="steps-container">
            <div class="section-title">
                <h2>Bagaimana Cara Kerjanya</h2>
            </div>
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Daftar</h3>
                    <p>Buat akun Parkeer Anda dengan cepat dan mudah.</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Cari & Reservasi</h3>
                    <p>Temukan tempat parkir dan reservasi sesuai kebutuhan Anda.</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Parkir & Bayar</h3>
                    <p>Parkir kendaraan Anda dan lakukan pembayaran dengan mudah.</p>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <h3>Kelola & Monitor</h3>
                    <p>Pantau status parkir dan kelola reservasi Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials" id="testimonials">
        <div class="section-title">
            <h2>Apa Kata Mereka</h2>
        </div>
        <div class="testimonial-grid">
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <p>Parkeer telah mengubah cara kami mengelola parkir di mal kami. Efisiensi meningkat hingga 40% dan keluhan pelanggan menurun drastis!</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="/api/placeholder/50/50" alt="Ahmad">
                    </div>
                    <div class="author-info">
                        <h4>Ahmad Setiawan</h4>
                        <p>Manajer Operasional, Grand Mall</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <p>Sebagai pengguna, saya sangat puas dengan kemudahan menemukan tempat parkir melalui aplikasi Parkeer. Tidak perlu lagi berputar-putar mencari spot kosong!</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="/api/placeholder/50/50" alt="Siti">
                    </div>
                    <div class="author-info">
                        <h4>Siti Rahayu</h4>
                        <p>Pengguna Aplikasi</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <p>Implementasi sistem Parkeer di area komersial kami telah meningkatkan pendapatan parkir sebesar 25% dan mengurangi kemacetan hingga 30%.</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="/api/placeholder/50/50" alt="Budi">
                    </div>
                    <div class="author-info">
                        <h4>Budi Pratama</h4>
                        <p>Direktur, PT Properti Jaya</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-container">
            <h2>Siap Mengoptimalkan Sistem Parkir Anda?</h2>
            <p>Bergabunglah dengan ribuan pengguna yang telah merasakan manfaat Parkeer dalam mengelola sistem parkir mereka.</p>
            <a href="#" class="btn-primary">Mulai Sekarang</a>
            <div class="app-buttons">
                <a href="#" class="app-button">
                    <i class="bi bi-apple"></i>
                    <div class="app-button-text">
                        <small>Unduh di</small>
                        <span>App Store</span>
                    </div>
                </a>
                <a href="#" class="app-button">
                    <i class="bi bi-google-play"></i>
                    <div class="app-button-text">
                        <small>Tersedia di</small>
                        <span>Google Play</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="footer-container">
            <div class="footer-about">
                <a href="#" class="footer-logo">Parkeer</a>
                <p>Parkeer adalah solusi manajemen parkir kendaraan berbasis teknologi yang dirancang untuk mengoptimalkan penggunaan area parkir dan meningkatkan pengalaman pengguna.</p>
                <div class="social-links">
                    <a href="#" class="social-icon">
                        <i class="bif bi-facebook"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="bif bi-instagram"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="bif bi-twitter"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="bif bi-youtube"></i>
                    </a>
                </div>
            </div>
            <div class="footer-links">
                <h3>Layanan</h3>
                <ul>
                    <li><a href="#">Parkir Komersial</a></li>
                    <li><a href="#">Parkir Residensial</a></li>
                    <li><a href="#">Event Parking</a></li>
                    <li><a href="#">Corporate Solutions</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h3>Perusahaan</h3>
                <ul>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Karir</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Press Kit</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h3>Bantuan</h3>
                <ul>
                    <li><a href="#">Pusat Bantuan</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Kontak</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 Parkeer. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>