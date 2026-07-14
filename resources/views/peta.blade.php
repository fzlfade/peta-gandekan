<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peta Rumah Warga — Gandekan</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; display: flex; height: 100vh; }
        #sidebar { width: 320px; overflow-y: auto; background: #f8fafc; border-right: 1px solid #e2e8f0; padding: 1rem; flex-shrink: 0; }
        #sidebar h1 { font-size: 1.125rem; font-weight: 600; margin-bottom: 0.25rem; }
        #sidebar p.sub { font-size: 0.75rem; color: #64748b; margin-bottom: 1rem; }
        #sidebar input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; font-size: 0.875rem; margin-bottom: 1rem; }
        #sidebar input:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 2px rgba(59,130,246,0.2); }
        .resident-item { padding: 0.75rem; border-radius: 0.375rem; cursor: pointer; border-bottom: 1px solid #e2e8f0; transition: background 0.15s; }
        .resident-item:hover { background: #e2e8f0; }
        .resident-item .name { font-weight: 500; font-size: 0.875rem; }
        .resident-item .addr { font-size: 0.75rem; color: #64748b; margin-top: 0.125rem; }
        .resident-item .nav-link { display: inline-block; margin-top: 0.25rem; font-size: 0.75rem; color: #2563eb; text-decoration: none; }
        .resident-item .nav-link:hover { text-decoration: underline; }
        #map { flex: 1; height: 100vh; }
        @media (max-width: 768px) { body { flex-direction: column; } #sidebar { width: 100%; height: 40vh; border-right: none; border-bottom: 1px solid #e2e8f0; } #map { height: 60vh; } }
    </style>
</head>
<body>
    <div id="sidebar">
        <h1>🏠 Rumah Warga Gandekan</h1>
        <p class="sub">Klik item untuk fokus ke peta</p>
        <input type="text" id="search" placeholder="Cari nama pemilik..." oninput="filterResidents(this.value)">
        <div id="resident-list"></div>
    </div>
    <div id="map"></div>

    <script>
        const map = L.map('map').setView([-7.7316946528213, 110.33960979406231], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const residents = @json($residents);
        const markers = [];

        function buildList(data) {
            const list = document.getElementById('resident-list');
            list.innerHTML = data.map(r => `
                <div class="resident-item" data-lat="${r.latitude}" data-lng="${r.longitude}" onclick="focusResident(${r.latitude}, ${r.longitude})">
                    <div class="name">${r.nama_pemilik}</div>
                    <div class="addr">${r.alamat}</div>
                    <a class="nav-link" href="https://www.google.com/maps/dir/?api=1&destination=${r.latitude},${r.longitude}" target="_blank" rel="noopener" onclick="event.stopPropagation()">📍 Navigasi</a>
                </div>
            `).join('');
        }

        function focusResident(lat, lng) {
            map.flyTo([lat, lng], 18, { animate: true, duration: 1.5 });
        }

        function filterResidents(query) {
            const q = query.toLowerCase();
            const filtered = residents.filter(r => r.nama_pemilik.toLowerCase().includes(q));
            buildList(filtered);
        }

        residents.forEach(r => {
            const marker = L.marker([r.latitude, r.longitude]).addTo(map);
            marker.bindPopup(`
                <strong>${r.nama_pemilik}</strong><br>
                ${r.alamat}<br>
                <a href="https://www.google.com/maps/dir/?api=1&destination=${r.latitude},${r.longitude}" target="_blank" rel="noopener">📍 Navigasi ke lokasi</a>
            `);
            markers.push(marker);
        });

        buildList(residents);
    </script>
</body>
</html>
