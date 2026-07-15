<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rumah Kita Gandekan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100">
    <nav class="sticky top-0 z-50 bg-white/80 dark:bg-gray-950/80 backdrop-blur-xl border-b border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">Rumah Kita Gandekan</a>
                <div class="flex items-center gap-6">
                    <a href="#features" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Fitur</a>
                    <a href="{{ url('/peta') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Peta</a>
                    <a href="{{ url('/admin') }}" class="px-4 py-2 text-sm font-medium bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">Admin</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="relative overflow-hidden pt-16 pb-24 px-6">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-cyan-50 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900 pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-blue-100/50 to-transparent dark:from-blue-950/20 pointer-events-none"></div>
        <div class="max-w-6xl mx-auto relative">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="flex-1 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 rounded-full text-xs font-medium mb-6">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" /></svg>
                        KKN Tlogoadi 2026
                    </div>
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight mb-6">
                        <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-cyan-500 bg-clip-text text-transparent">Rumah Kita</span><br>
                        <span>Gandekan</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 leading-relaxed max-w-xl mb-10">
                        Peta interaktif untuk menjelajahi sebaran rumah warga di Gandekan, Tlogoadi. 
                        Temukan lokasi, dapatkan arah navigasi, dan kenali lingkungan sekitar dengan mudah.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ url('/peta') }}" class="px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/25 hover:shadow-xl hover:shadow-blue-600/30 hover:-translate-y-0.5 transition-all text-center">
                            Buka Peta Interaktif
                        </a>
                        <a href="#features" class="px-8 py-3.5 font-semibold text-gray-900 dark:text-white border-2 border-gray-300 dark:border-gray-700 hover:border-blue-600 dark:hover:border-blue-500 rounded-xl transition-all text-center">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="flex-1 w-full max-w-lg lg:max-w-none">
                    <div class="relative">
                        <div class="absolute -inset-4 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-3xl opacity-20 blur-2xl"></div>
                        <div class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
                            <div class="p-4 border-b border-gray-200 dark:border-gray-800 flex items-center gap-2">
                                <div class="flex gap-1.5">
                                    <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                    <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                </div>
                                <span class="text-xs text-gray-400 ml-2">rumahkitagandekan.id</span>
                            </div>
                            <div class="aspect-[4/3] bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                <div class="text-center p-8">
                                    <div class="text-6xl mb-4">🏘️</div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Peta interaktif dengan Leaflet.js</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-24 px-6 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">Fitur Unggulan</h2>
                <p class="text-gray-600 dark:text-gray-400 max-w-xl mx-auto">Semua yang Anda butuhkan untuk menjelajahi dan mengelola data rumah warga di Gandekan.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="group relative bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-200 dark:border-gray-700 hover:border-blue-400 dark:hover:border-blue-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Peta Interaktif</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Visualisasi real-time lokasi rumah warga dengan marker pinpoint akurat. Teknologi Leaflet.js + OpenStreetMap.</p>
                </div>
                <div class="group relative bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-200 dark:border-gray-700 hover:border-blue-400 dark:hover:border-blue-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Navigasi Instant</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Navigasi langsung ke lokasi rumah warga via Google Maps tanpa API key. Kompatibel mobile & desktop.</p>
                </div>
                <div class="group relative bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-200 dark:border-gray-700 hover:border-blue-400 dark:hover:border-blue-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Informasi Lengkap</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Data kepemilikan rumah dan alamat lengkap via popup informatif atau sidebar navigasi yang responsif.</p>
                </div>
                <div class="group relative bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-200 dark:border-gray-700 hover:border-blue-400 dark:hover:border-blue-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/50 text-amber-600 dark:text-amber-400 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Pencarian Cepat</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Filter dan cari pemilik rumah secara real-time. Temukan lokasi dengan mudah via nama atau alamat.</p>
                </div>
                <div class="group relative bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-200 dark:border-gray-700 hover:border-blue-400 dark:hover:border-blue-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-rose-100 dark:bg-rose-900/50 text-rose-600 dark:text-rose-400 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Responsive Design</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Antarmuka optimal di semua perangkat. Dari smartphone hingga desktop, pengalaman tetap konsisten.</p>
                </div>
                <div class="group relative bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-200 dark:border-gray-700 hover:border-blue-400 dark:hover:border-blue-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-cyan-100 dark:bg-cyan-900/50 text-cyan-600 dark:text-cyan-400 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Performa Optimal</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Aplikasi ringan dan cepat dengan bundle size minimal. Loading instant tanpa biaya server API mahal.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="cta" class="py-24 px-6">
        <div class="max-w-4xl mx-auto text-center">
            <div class="bg-gradient-to-br from-blue-600 via-indigo-600 to-cyan-500 rounded-3xl p-12 md:p-16 shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-20 -mt-20"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -ml-12 -mb-12"></div>
                <div class="relative">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Siap Menjelajahi Gandekan?</h2>
                    <p class="text-blue-100 text-lg mb-8 max-w-lg mx-auto">Buka peta interaktif dan lihat sebaran lokasi rumah warga secara real-time.</p>
                    <a href="{{ url('/peta') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-white text-blue-700 font-semibold rounded-xl hover:bg-blue-50 hover:-translate-y-0.5 transition-all shadow-xl">
                        Mulai Sekarang
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-xl font-bold bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">Rumah Kita Gandekan</div>
                <p class="text-sm text-gray-500 dark:text-gray-400">&copy; 2026 Rumah Kita Gandekan. Dibuat untuk KKN Tlogoadi.</p>
            </div>
        </div>
    </footer>
</body>
</html>