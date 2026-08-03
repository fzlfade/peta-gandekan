<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Warga Gandekan - Membangun Bersama Untuk Warga</title>
    
    <!-- Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300..900;1,300..900&family=Atkinson+Hyperlegible+Next:ital,wght@0,200..800;1,200..800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Leaflet & App Styles -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-on-background selection:bg-primary-container selection:text-on-primary-container font-body-md" x-data="{ mobileMenuOpen: false }">
    <!-- Header / TopNavBar -->
    <header class="fixed top-0 left-0 w-full z-50 bg-surface border-b border-outline-variant">
        <nav class="flex justify-between items-center px-gutter py-4 w-full max-w-container-max mx-auto">
            <a href="/" class="text-headline-md font-headline-lg text-primary tracking-tight font-bold text-lg md:text-2xl">Peta Warga Gandekan</a>
            <div class="hidden md:flex items-center gap-8">
                <a class="text-primary border-b-2 border-primary pb-1 font-bold font-label-md" href="#">Home</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors font-label-md" href="#features">Fitur</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors font-label-md" href="#how-it-works">Cara Kerja</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors font-label-md" href="{{ url('/peta') }}">Peta Interaktif</a>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="bg-primary text-on-primary px-4 md:px-6 py-2 md:py-2.5 rounded-lg font-label-md hover:bg-primary-container hover:text-on-primary-container active:scale-95 transition-all text-xs md:text-sm">
                        Dashboard Admin
                    </a>
                @else
                    <a href="{{ url('/peta') }}" class="hidden sm:inline-flex bg-primary text-on-primary px-6 py-2.5 rounded-lg font-label-md hover:bg-primary-container hover:text-on-primary-container active:scale-95 transition-all text-sm">
                        Buka Peta Sekarang
                    </a>
                @endauth
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-on-surface-variant hover:text-primary">
                    <span class="material-symbols-outlined text-[24px]" x-text="mobileMenuOpen ? 'close' : 'menu'">menu</span>
                </button>
            </div>
        </nav>
        
        <!-- Mobile Dropdown Navigation -->
        <div x-show="mobileMenuOpen" x-cloak @click.away="mobileMenuOpen = false" class="md:hidden bg-surface border-b border-outline-variant px-gutter py-4 space-y-3">
            <a class="block text-primary font-bold font-label-md py-1" href="#" @click="mobileMenuOpen = false">Home</a>
            <a class="block text-on-surface-variant hover:text-primary font-label-md py-1" href="#features" @click="mobileMenuOpen = false">Fitur</a>
            <a class="block text-on-surface-variant hover:text-primary font-label-md py-1" href="#how-it-works" @click="mobileMenuOpen = false">Cara Kerja</a>
            <a class="block text-on-surface-variant hover:text-primary font-label-md py-1" href="{{ url('/peta') }}" @click="mobileMenuOpen = false">Peta Interaktif</a>
            <a href="{{ url('/peta') }}" class="inline-block w-full text-center bg-primary text-on-primary px-4 py-2.5 rounded-lg font-label-md mt-2">
                Buka Peta Sekarang
            </a>
        </div>
    </header>

    <main class="pt-20">
        <!-- Hero Section -->
        <section class="relative min-h-[750px] md:min-h-[800px] flex items-center overflow-hidden hero-gradient">
            <div class="max-w-container-max mx-auto px-gutter w-full grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center py-stack-lg">
                <div class="space-y-stack-md z-10 text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-secondary-container text-on-secondary-container rounded-full text-label-sm uppercase tracking-wider">
                        <span class="material-symbols-outlined text-[16px]">location_on</span>
                        Inovasi Digital Gandekan
                    </div>
                    <h1 class="font-headline-lg text-display-lg-mobile md:text-display-lg leading-tight text-on-background">
                        Membangun Kedekatan Warga Melalui <span class="text-primary">Data Geografis</span>
                    </h1>
                    <p class="font-body-lg text-on-surface-variant max-w-xl">
                        Visualisasikan lokasi rumah warga, pantau statistik wilayah, dan tingkatkan transparansi layanan publik di Dusun Gandekan dengan sistem pemetaan modern.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="{{ url('/peta') }}" class="bg-primary text-on-primary px-8 py-4 rounded-xl font-headline-md flex items-center justify-center gap-3 shadow-lg shadow-primary/20 hover:-translate-y-0.5 transition-transform text-center">
                            Buka Peta Interaktif
                            <span class="material-symbols-outlined">map</span>
                        </a>
                        <a href="#features" class="bg-surface-bright text-primary border border-primary/20 px-8 py-4 rounded-xl font-headline-md hover:bg-surface-container transition-colors text-center">
                            Pelajari Selengkapnya
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <div class="aspect-[4/3] md:aspect-square bg-white rounded-3xl shadow-2xl overflow-hidden border border-outline-variant p-2 transform md:rotate-1 hover:rotate-0 transition-transform duration-500">
                        <div class="w-full h-full rounded-2xl bg-surface-container-lowest overflow-hidden relative" id="preview-map-container">
                            <div id="homepage-map" class="w-full h-full min-h-[300px] md:min-h-[350px]"></div>
                        </div>
                    </div>
                    <!-- Floating Stats Card -->
                    <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-2xl shadow-xl border border-outline-variant hidden lg:block z-10">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center">
                                <span class="material-symbols-outlined text-on-secondary-container">trending_up</span>
                            </div>
                            <div>
                                <p class="text-label-sm text-on-surface-variant">Terdata</p>
                                <p class="font-headline-md text-primary">{{ \App\Models\Warga::count() }} Rumah Warga</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="bg-inverse-surface py-12">
            <div class="max-w-container-max mx-auto px-gutter">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center justify-center text-center">
                    <div class="flex flex-col gap-1">
                        <span class="text-secondary-fixed text-display-lg-mobile font-headline-lg">{{ \App\Models\Warga::count() }}+</span>
                        <span class="text-surface-variant font-label-md uppercase tracking-widest">Warga Terdata</span>
                    </div>
                    <div class="flex flex-col gap-1 border-y md:border-y-0 md:border-x border-surface-variant/20 py-8 md:py-0">
                        <span class="text-secondary-fixed text-display-lg-mobile font-headline-lg">Dusun Gandekan</span>
                        <span class="text-surface-variant font-label-md uppercase tracking-widest">Kalurahan Tlogoadi</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-secondary-fixed text-display-lg-mobile font-headline-lg flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-4xl">sync</span>
                            Live
                        </span>
                        <span class="text-surface-variant font-label-md uppercase tracking-widest">Real-time Update</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-section-gap-lg bg-surface-bright" id="features">
            <div class="max-w-container-max mx-auto px-gutter">
                <div class="text-center mb-section-gap-md space-y-4">
                    <h2 class="font-headline-lg text-headline-lg text-on-background">Fitur Utama Sistem</h2>
                    <p class="font-body-lg text-on-surface-variant max-w-2xl mx-auto">Dirancang untuk memudahkan administrasi dan pencarian data warga dengan efisiensi maksimal.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                    <!-- Card 1 -->
                    <div class="group bg-white p-stack-lg rounded-xl border border-outline-variant hover:border-primary hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <div class="w-16 h-16 bg-surface-container rounded-lg flex items-center justify-center mb-stack-md group-hover:bg-primary group-hover:text-on-primary transition-colors">
                            <span class="material-symbols-outlined text-[32px]">location_searching</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md mb-stack-sm text-on-background">Pemetaan Akurat</h3>
                        <p class="font-body-md text-on-surface-variant">Visualisasi lokasi rumah warga berbasis Leaflet.js yang presisi, memungkinkan identifikasi titik koordinat setiap bangunan secara detail.</p>
                    </div>
                    <!-- Card 2 -->
                    <div class="group bg-white p-stack-lg rounded-xl border border-outline-variant hover:border-primary hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <div class="w-16 h-16 bg-surface-container rounded-lg flex items-center justify-center mb-stack-md group-hover:bg-primary group-hover:text-on-primary transition-colors">
                            <span class="material-symbols-outlined text-[32px]">analytics</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md mb-stack-sm text-on-background">Statistik Wilayah</h3>
                        <p class="font-body-md text-on-surface-variant">Analisis data kependudukan per RT/RW secara instan. Pantau demografi, jumlah kepala keluarga, dan pertumbuhan warga secara grafis.</p>
                    </div>
                    <!-- Card 3 -->
                    <div class="group bg-white p-stack-lg rounded-xl border border-outline-variant hover:border-primary hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <div class="w-16 h-16 bg-surface-container rounded-lg flex items-center justify-center mb-stack-md group-hover:bg-primary group-hover:text-on-primary transition-colors">
                            <span class="material-symbols-outlined text-[32px]">near_me</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md mb-stack-sm text-on-background">Akses Cepat</h3>
                        <p class="font-body-md text-on-surface-variant">Navigasi langsung ke lokasi warga melalui integrasi Google Maps API untuk efisiensi kunjungan lapangan dan logistik publik.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="py-section-gap-lg bg-surface" id="how-it-works">
            <div class="max-w-container-max mx-auto px-gutter">
                <div class="flex flex-col md:flex-row gap-12 md:gap-16 items-center">
                    <div class="w-full md:w-1/2">
                        <div class="bg-surface-container-lowest p-6 md:p-8 rounded-2xl shadow-lg border border-outline-variant space-y-6">
                            <div class="flex items-center gap-4 border-b border-outline-variant pb-4">
                                <span class="material-symbols-outlined text-primary text-[36px]">map</span>
                                <div>
                                    <h3 class="font-headline-md text-on-background text-lg md:text-xl">Peta Wilayah Gandekan</h3>
                                    <p class="text-label-md text-on-surface-variant text-xs md:text-sm">Sistem Informasi Geografis Warga</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="p-4 bg-surface-container-low rounded-lg border border-outline-variant flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-primary">search</span>
                                        <span class="text-body-md text-on-surface text-sm md:text-base">Pencarian Nama & Alamat</span>
                                    </div>
                                    <span class="px-2 py-1 bg-secondary-container text-on-secondary-container text-label-sm rounded">Aktif</span>
                                </div>
                                <div class="p-4 bg-surface-container-low rounded-lg border border-outline-variant flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-primary">pin_drop</span>
                                        <span class="text-body-md text-on-surface text-sm md:text-base">Pinpoint Koordinat Presisi</span>
                                    </div>
                                    <span class="px-2 py-1 bg-secondary-container text-on-secondary-container text-label-sm rounded">Aktif</span>
                                </div>
                                <div class="p-4 bg-surface-container-low rounded-lg border border-outline-variant flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-primary">navigation</span>
                                        <span class="text-body-md text-on-surface text-sm md:text-base">Rute Direct Google Maps</span>
                                    </div>
                                    <span class="px-2 py-1 bg-secondary-container text-on-secondary-container text-label-sm rounded">Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 space-y-stack-lg">
                        <h2 class="font-headline-lg text-headline-lg text-on-background">Cara Kerja Sistem</h2>
                        <div class="space-y-8">
                            <div class="flex gap-6">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold">1</div>
                                <div>
                                    <h4 class="font-headline-md text-headline-md text-on-background">Cari Data</h4>
                                    <p class="font-body-md text-on-surface-variant">Gunakan fitur pencarian cerdas untuk menemukan data warga berdasarkan nama pemilik atau alamat rumah.</p>
                                </div>
                            </div>
                            <div class="flex gap-6">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold">2</div>
                                <div>
                                    <h4 class="font-headline-md text-headline-md text-on-background">Temukan Lokasi</h4>
                                    <p class="font-body-md text-on-surface-variant">Sistem akan secara otomatis memusatkan peta pada koordinat rumah yang dicari dengan penanda visual yang jelas.</p>
                                </div>
                            </div>
                            <div class="flex gap-6">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold">3</div>
                                <div>
                                    <h4 class="font-headline-md text-headline-md text-on-background">Mulai Navigasi</h4>
                                    <p class="font-body-md text-on-surface-variant">Dapatkan rute tercepat menuju lokasi langsung dari posisi Anda saat ini menggunakan integrasi Google Maps.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Final CTA Section -->
        <section class="py-section-gap-lg px-gutter">
            <div class="max-w-container-max mx-auto bg-inverse-surface rounded-[24px] md:rounded-[40px] overflow-hidden relative p-8 sm:p-12 md:p-24 text-center">
                <div class="relative z-10 max-w-3xl mx-auto space-y-stack-md">
                    <h2 class="font-headline-lg text-display-lg-mobile md:text-display-lg text-surface-bright">Siap Menjelajahi Gandekan?</h2>
                    <p class="font-body-lg text-surface-variant opacity-80">
                        Mari bersama wujudkan tata kelola data warga yang transparan dan berbasis teknologi untuk masa depan Kelurahan Gandekan yang lebih baik.
                    </p>
                    <div class="pt-6 sm:pt-8">
                        <a href="{{ url('/peta') }}" class="inline-block bg-secondary-container text-on-secondary-container px-8 sm:px-12 py-4 sm:py-5 rounded-full font-headline-md text-base sm:text-lg hover:scale-105 active:scale-95 transition-all shadow-xl shadow-secondary/20">
                            Akses Aplikasi Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-inverse-surface text-surface-variant border-t border-surface-variant/10">
        <div class="w-full py-stack-lg px-gutter flex flex-col md:flex-row justify-between items-center max-w-container-max mx-auto gap-8">
            <div class="flex flex-col items-center md:items-start gap-4">
                <div class="font-headline-md text-headline-md text-surface-bright">Peta Warga Gandekan</div>
                <p class="text-sm opacity-60 text-center md:text-left">© 2026 Peta Warga Gandekan. KKN Tlogoadi Untidar 2026.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-8">
                <a class="text-surface-variant opacity-80 hover:opacity-100 hover:text-secondary-fixed transition-all font-label-sm uppercase tracking-wider" href="{{ url('/peta') }}">Peta Interaktif</a>
                <a class="text-surface-variant opacity-80 hover:opacity-100 hover:text-secondary-fixed transition-all font-label-sm uppercase tracking-wider" href="#features">Fitur Utama</a>
                <a class="text-surface-variant opacity-80 hover:opacity-100 hover:text-secondary-fixed transition-all font-label-sm uppercase tracking-wider" href="{{ url('/login') }}">Login Admin</a>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const map = L.map('homepage-map', { zoomControl: false }).setView([-7.7316946528213, 110.33960979406231], 16);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            const residents = @json(\App\Models\Warga::all());
            residents.forEach(r => {
                const marker = L.marker([r.latitude, r.longitude]).addTo(map);
                marker.bindPopup(`
                    <div class="p-3">
                        <h4 class="font-bold text-on-surface text-sm">${r.nama_pemilik}</h4>
                        <p class="text-xs text-on-surface-variant mt-1">${r.alamat}</p>
                    </div>
                `);
            });
        });
    </script>
</body>
</html>