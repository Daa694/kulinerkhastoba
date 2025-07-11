<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuliner Khas Toba</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', 'Poppins', sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
            background: #F7F1E5;
            min-height: 100vh;
        }
        .bg-danau {
            background: url('/images/danautoba.webp') center center/cover no-repeat;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            z-index: 0;
            opacity: 0.15;
        }
        .navbar-welcome {
            font-family: 'Poppins', sans-serif;
            background: #2C3639;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
        }
        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 2rem;
        }
        .navbar-logo {
            display: flex;
            align-items: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 1px;
        }
        .navbar-logo img {
            height: 44px;
            width: 44px;
            border-radius: 50%;
            margin-right: 0.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
        }
        .navbar-links {
            display: flex;
            gap: 2rem;
        }
        .navbar-links a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            position: relative;
            transition: color 0.3s;
        }
        .navbar-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #D2552D;
            transition: width 0.3s;
        }
        .navbar-links a:hover {
            color: #D2552D;
        }
        .navbar-links a:hover::after {
            width: 100%;
        }
        .navbar-action {
            margin-left: 2rem;
        }
        .cta-button {
            background: #fff;
            color: #D2552D;
            padding: 0.75rem 1.5rem;
            border: 2px solid #D2552D;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: none;
        }
        .cta-button:hover {
            background: #D2552D;
            color: #fff;
            box-shadow: none;
        }
        .hero {
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            position: relative; 
            z-index: 1;
            background: #F7F1E5;
        }
        .hero-content {
            max-width: 700px; 
            margin: 0 auto; 
            padding: 2rem; 
            text-align: center; 
            position: relative; 
            z-index: 2;
            background: rgba(255,255,255,0.9); 
            border-radius: 24px; 
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
        }
        .hero h1 { 
            font-size: 2.7rem; 
            font-weight: 800; 
            color: #D2552D; 
            margin-bottom: 1rem; 
            letter-spacing: 1px; 
        }
        .hero p { 
            font-size: 1.2rem; 
            color: #333; 
            margin-bottom: 2rem; 
        }
        .hero-buttons { 
            display: flex; 
            gap: 1rem; 
            justify-content: center; 
            flex-wrap: wrap; 
        }
        .btn-primary {
            background: #D2552D;
            color: white; 
            padding: 1rem 2rem; 
            border: none; 
            border-radius: 50px;
            font-weight: 600; 
            text-decoration: none; 
            transition: all 0.3s; 
            box-shadow: 0 4px 15px rgba(210, 85, 45, 0.15);
        }
        .btn-primary:hover { 
            background: #B54424; 
            transform: translateY(-2px);
        }
        .btn-secondary {
            color: #D2552D; 
            border: 2px solid #D2552D; 
            padding: 1rem 2rem; 
            border-radius: 50px;
            font-weight: 600; 
            text-decoration: none; 
            transition: all 0.3s;
            background: white;
        }
        .btn-secondary:hover { 
            background: #D2552D; 
            color: #fff; 
            transform: translateY(-2px);
        }
        .features { 
            padding: 5rem 2rem 3rem; 
            background: #F7F1E5; 
            position: relative; 
            z-index: 1; 
        }
        .features-container { 
            max-width: 1200px; 
            margin: 0 auto; 
        }
        .section-title { 
            text-align: center; 
            font-size: 2.2rem; 
            font-weight: 700; 
            color: #D2552D; 
            margin-bottom: 2.5rem; 
        }
        .features-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); 
            gap: 2rem; 
        }
        .feature-card {
            background: #fff; 
            padding: 2rem; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.07);
            transition: all 0.3s; 
            border: 1px solid rgba(0,0,0,0.04);
        }
        .feature-card:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 20px 40px rgba(210, 85, 45, 0.1); 
        }
        .feature-icon {
            width: 60px; 
            height: 60px; 
            background: #D2552D;
            border-radius: 15px;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin-bottom: 1rem;
        }
        .feature-icon svg { 
            width: 30px; 
            height: 30px; 
            fill: white; 
        }
        .feature-card h3 { 
            font-size: 1.2rem; 
            font-weight: 600; 
            color: #D2552D; 
            margin-bottom: 0.7rem; 
        }
        .feature-card p { 
            color: #666; 
            line-height: 1.6; 
            font-size: 1rem; 
        }
        .footer {
            background: #2C3639; 
            color: white; 
            padding: 2.5rem 2rem 1rem;
        }
        .footer-container { 
            max-width: 1200px; 
            margin: 0 auto; 
            text-align: center; 
        }
        .footer-links { 
            display: flex; 
            justify-content: center; 
            gap: 2rem; 
            margin-bottom: 2rem; 
            flex-wrap: wrap; 
        }
        .footer-links a { 
            color: #ccc; 
            text-decoration: none; 
            transition: color 0.3s; 
        }
        .footer-links a:hover { 
            color: #D2552D; 
        }
        .footer-bottom { 
            border-top: 1px solid #3a4447; 
            padding-top: 1rem; 
            color: #888; 
        }
        @media (max-width: 768px) {
            .nav { padding: 1rem; }
            .nav-links { display: none; }
            .hero h1 { font-size: 1.7rem; }
            .hero p { font-size: 1rem; }
            .hero-buttons { flex-direction: column; align-items: center; }
            .section-title { font-size: 1.3rem; }
            .features { padding: 2rem 1rem; }
        }
    </style>
</head>
<body>
    <div class="bg-danau"></div>
    <!-- Header/Navbar -->
    <nav class="navbar-welcome">
        <div class="navbar-container">
            <div class="navbar-logo">
                <!-- Uncomment if you have a logo image -->
                <!-- <img src="{{ asset('images/tobataste.png') }}" alt="Logo"> -->
                Kuliner Khas Toba
            </div>
            <div class="navbar-links">
                <a href="#features">Fitur</a>
                <a href="#footer">Kontak</a>
            </div>
            <div class="navbar-action">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}" class="cta-button">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="cta-button">Masuk</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>
    <div style="height: 80px;"></div>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Eksplorasi Kuliner Khas Toba</h1>
            <p>Temukan cita rasa autentik dan keindahan budaya Toba melalui ragam kuliner khas, langsung dari tepian Danau Toba. Nikmati pengalaman kuliner, ulasan, dan rekomendasi terbaik untuk Anda dan keluarga.</p>
            <div class="hero-buttons">
                <a href="{{ route('login') }}" class="btn-primary">Mulai Jelajah</a>
                <a href="#features" class="btn-secondary">Lihat Fitur</a>
            </div>
        </div>
    </section>
    <!-- Features Section -->
    <section class="features" id="features">
        <div class="features-container">
            <h2 class="section-title">Fitur Unggulan</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 2L2 7v10c0 5.55 3.84 9.739 9 11 5.16-1.261 9-5.45 9-11V7l-10-5z"/></svg>
                    </div>
                    <h3>Galeri Kuliner</h3>
                    <p>Lihat foto-foto makanan khas Toba dengan tampilan menarik dan detail lengkap.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <h3>Rating & Ulasan</h3>
                    <p>Berikan penilaian dan komentar pada setiap menu, serta baca ulasan dari pengguna lain.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                    <h3>Admin Dashboard</h3>
                    <p>Kelola data kuliner, ulasan, dan pengguna dengan mudah melalui dashboard admin.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <h3>Rekomendasi Menu</h3>
                    <p>Dapatkan rekomendasi menu favorit berdasarkan rating dan ulasan terbaik.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                    <h3>Transaksi Mudah</h3>
                    <p>Pemesanan dan pembayaran online yang praktis dan aman.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <h3>Komunitas & Event</h3>
                    <p>Ikuti event kuliner dan terhubung dengan komunitas pecinta kuliner Toba.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="footer" id="footer">
        <div class="footer-container">
            <div class="footer-links">
                <a href="https://instagram.com" target="_blank">Instagram</a>
                <a href="https://facebook.com" target="_blank">Facebook</a>
                <a href="https://wa.me/" target="_blank">WhatsApp</a>
                <a href="mailto:info@kulinertoba.com">Email</a>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Kuliner Khas Toba. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href.length > 1 && document.querySelector(href)) {
                    e.preventDefault();
                    document.querySelector(href).scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
        // Header background change on scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255,255,255,0.98)';
            } else {
                header.style.background = 'rgba(255,255,255,0.92)';
            }
        });
    </script>
</body>
</html>