<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peta — Rumah Kita Gandekan</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite(['resources/css/app.css'])
</head>
<body class="h-screen bg-white dark:bg-gray-900">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-full md:w-96 flex flex-col bg-white dark:bg-gray-800 border-b md:border-b-0 md:border-r border-gray-200 dark:border-gray-700">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 shrink-0">
                <a href="/" class="inline-flex items-center gap-2 mb-4 text-lg font-bold bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" /></svg>
                    Rumah Kita Gandekan
                </a>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Daftar Warga</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">Klik untuk navigasi ke lokasi</p>
            </div>

            <!-- Search -->
            <div class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 shrink-0">
                <input type="text" id="search" placeholder="🔍 Cari nama pemilik..." oninput="filterResidents(this.value)" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
            </div>

            <!-- List -->
            <div id="resident-list" class="flex-1 overflow-y-auto p-4 space-y-2"></div>
        </div>

        <!-- Map -->
        <div id="map" class="flex-1 h-full"></div>
    </div>

    <script>
        const map = L.map('map').setView([-7.7316946528213, 110.33960979406231], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const residents = @json($residents);
        const markers = [];
        let activeMarker = null;

        function buildList(data) {
            const list = document.getElementById('resident-list');
            if (data.length === 0) {
                list.innerHTML = '<div class="px-4 py-12 text-center text-gray-400">Tidak ada hasil pencarian</div>';
                return;
            }
            list.innerHTML = data.map(r => `
                <div class="resident-item group p-4 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 border border-transparent hover:border-blue-400 dark:hover:border-blue-500 hover:shadow-md transition-all duration-200" data-lat="${r.latitude}" data-lng="${r.longitude}" data-id="${r.id}" onclick="focusResident(${r.latitude}, ${r.longitude}, ${r.id})">
                    <div class="flex items-start justify-between mb-2">
                        <div class="font-semibold text-sm text-gray-900 dark:text-white pr-2">${r.nama_pemilik}</div>
                        <span class="text-xs px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 rounded-full whitespace-nowrap">ID: ${r.id}</span>
                    </div>
                    <div class="text-xs text-gray-600 dark:text-gray-300 line-clamp-2 mb-3">${r.alamat}</div>
                    <a class="text-xs font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 transition-colors inline-flex items-center gap-1" href="https://www.google.com/maps/dir/?api=1&destination=${r.latitude},${r.longitude}" target="_blank" rel="noopener" onclick="event.stopPropagation()">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                        Navigasi
                    </a>
                </div>
            `).join('');
        }

        function focusResident(lat, lng, id) {
            map.flyTo([lat, lng], 18, { animate: true, duration: 1.2 });
            markers.forEach(m => {
                if (m.options.residentId === id) {
                    setTimeout(() => m.openPopup(), 400);
                }
            });
        }

        function filterResidents(query) {
            const q = query.toLowerCase();
            buildList(residents.filter(r => 
                r.nama_pemilik.toLowerCase().includes(q) || 
                r.alamat.toLowerCase().includes(q)
            ));
        }

        residents.forEach(r => {
            const m = L.marker([r.latitude, r.longitude]);
            m.options.residentId = r.id;
            m.addTo(map);
            m.bindPopup(`
                <div class="font-sans">
                    <div class="font-semibold text-sm text-gray-900 mb-1">${r.nama_pemilik}</div>
                    <div class="text-xs text-gray-600 mb-3 max-w-xs">${r.alamat}</div>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=${r.latitude},${r.longitude}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded transition-colors">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                        Navigasi
                    </a>
                </div>
            `);
            markers.push(m);
        });
        buildList(residents);
    </script>
</body>
</html>