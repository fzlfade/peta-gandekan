<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Rumah Warga — Gandekan</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap');
        </style>
    @endif
    <style>
        :root {
            --background: 0 0% 100%;
            --foreground: 0 0% 3.6%;
            --card: 0 0% 100%;
            --card-foreground: 0 0% 3.6%;
            --primary: 200 100% 50%;
            --primary-foreground: 0 0% 100%;
            --secondary: 160 84% 39%;
            --secondary-foreground: 0 0% 100%;
            --muted: 0 0% 96.1%;
            --muted-foreground: 0 0% 45.1%;
            --accent: 0 84% 60%;
            --accent-foreground: 0 0% 100%;
            --destructive: 0 84% 60%;
            --destructive-foreground: 0 0% 100%;
            --border: 0 0% 89.8%;
            --input: 0 0% 89.8%;
            --ring: 200 100% 50%;
            --radius: 0.5rem;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --background: 0 0% 3.6%;
                --foreground: 0 0% 98.2%;
                --card: 0 0% 10%;
                --card-foreground: 0 0% 98.2%;
                --primary: 200 100% 50%;
                --primary-foreground: 0 0% 0%;
                --secondary: 160 84% 39%;
                --secondary-foreground: 0 0% 100%;
                --muted: 0 0% 14.9%;
                --muted-foreground: 0 0% 63.9%;
                --accent: 0 84% 60%;
                --accent-foreground: 0 0% 0%;
                --border: 0 0% 14.9%;
                --input: 0 0% 14.9%;
                --ring: 200 100% 50%;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Instrument Sans', system-ui, sans-serif;
            background-color: hsl(var(--background));
            color: hsl(var(--foreground));
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Navigation */
        nav {
            position: sticky;
            top: 0;
            z-index: 50;
            background-color: hsl(var(--background) / 0.8);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid hsl(var(--border));
            padding: 1rem 0;
        }

        nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, hsl(var(--primary)), hsl(var(--secondary)));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        nav ul {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        nav a {
            text-decoration: none;
            color: hsl(var(--foreground));
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        nav a:hover {
            color: hsl(var(--primary));
        }

        /* Hero Section */
        .hero {
            padding: 6rem 1rem;
            text-align: center;
        }

        .hero-content {
            max-width: 900px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero p {
            font-size: clamp(1rem, 2vw, 1.25rem);
            color: hsl(var(--muted-foreground));
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 4rem;
        }

        .btn {
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            border: none;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
            font-family: 'Instrument Sans', system-ui, sans-serif;
        }

        .btn-primary {
            background-color: hsl(var(--primary));
            color: hsl(var(--primary-foreground));
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-outline {
            background-color: transparent;
            color: hsl(var(--primary));
            border: 1.5px solid hsl(var(--primary));
        }

        .btn-outline:hover {
            background-color: hsl(var(--primary) / 0.1);
            transform: translateY(-2px);
        }

        /* Features Grid */
        .features {
            padding: 4rem 1rem;
            background-color: hsl(var(--muted) / 0.3);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            background-color: hsl(var(--card));
            padding: 2rem;
            border-radius: 0.75rem;
            border: 1px solid hsl(var(--border));
            transition: all 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            border-color: hsl(var(--primary));
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .feature-card p {
            color: hsl(var(--muted-foreground));
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* CTA Section */
        .cta {
            padding: 4rem 1rem;
            text-align: center;
        }

        .cta h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .cta p {
            font-size: 1.1rem;
            color: hsl(var(--muted-foreground));
            margin-bottom: 2rem;
        }

        /* Footer */
        footer {
            background-color: hsl(var(--muted) / 0.5);
            border-top: 1px solid hsl(var(--border));
            padding: 2rem 1rem;
            text-align: center;
            color: hsl(var(--muted-foreground));
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            nav ul {
                gap: 1rem;
            }

            .hero {
                padding: 4rem 1rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="container">
            <div class="logo">🏘️ Gandekan</div>
            <ul>
                <li><a href="#features">Fitur</a></li>
                <li><a href="#cta">Mulai</a></li>
                <li><a href="{{ url('/admin') }}">Admin</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Sistem Informasi Rumah Warga</h1>
            <p>Visualisasi interaktif sebaran lokasi rumah warga di wilayah Gandekan. Akses informasi kepemilikan rumah dan navigasi rute secara instant.</p>
            <div class="hero-buttons">
                <a href="{{ url('/peta') }}" class="btn btn-primary">Buka Peta Interaktif</a>
                <a href="#features" class="btn btn-outline">Pelajari Lebih Lanjut</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <h2 style="font-size: 2rem; font-weight: 700; text-align: center;">Fitur Utama</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🗺️</div>
                    <h3>Peta Interaktif</h3>
                    <p>Visualisasi real-time lokasi rumah warga dengan marker pinpoint yang akurat. Teknologi Leaflet.js + OpenStreetMap.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📍</div>
                    <h3>Navigasi Instant</h3>
                    <p>Navigasi langsung ke lokasi rumah warga menggunakan Google Maps tanpa perlu API key. Kompatibel mobile dan desktop.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3>Informasi Lengkap</h3>
                    <p>Akses data kepemilikan rumah dan alamat lengkap melalui popup informatif atau sidebar navigasi yang responsif.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔍</div>
                    <h3>Pencarian Cepat</h3>
                    <p>Filter dan cari pemilik rumah secara real-time di sidebar. Temukan lokasi dengan mudah melalui nama atau alamat.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3>Responsive Design</h3>
                    <p>Antarmuka yang sempurna di semua perangkat. Dari smartphone hingga desktop, pengalaman yang konsisten.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3>Performa Optimal</h3>
                    <p>Aplikasi ringan dan cepat dengan bundle size minimal. Loading instant tanpa biaya server API mahal.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="cta" class="cta">
        <div class="container">
            <h2>Siap Menjelajahi Rumah Warga Gandekan?</h2>
            <p>Buka peta interaktif dan lihat sebaran lokasi rumah warga secara real-time.</p>
            <a href="{{ url('/peta') }}" class="btn btn-primary">Mulai Sekarang →</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2026 Sistem Informasi Rumah Warga Gandekan. Dibuat dengan ❤️ untuk KKN Gandekan.</p>
        </div>
    </footer>
</body>
</html>
