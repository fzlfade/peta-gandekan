<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Data — Rumah Kita Gandekan</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100">
    <div class="min-h-screen py-10 px-4">
        <div class="max-w-2xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <a href="{{ route('admin.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors inline-flex items-center gap-1 mb-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                        Kembali
                    </a>
                    <h1 class="text-2xl font-bold">Tambah Data Warga</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Klik pada peta untuk menentukan lokasi rumah</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-sm p-8">
                <form action="{{ route('admin.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="nama_pemilik" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nama Pemilik</label>
                            <input type="text" name="nama_pemilik" id="nama_pemilik" value="{{ old('nama_pemilik') }}" required placeholder="Nama lengkap pemilik rumah" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition placeholder-gray-400">
                            @error('nama_pemilik') <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="alamat" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="2" required placeholder="Alamat lengkap rumah" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition placeholder-gray-400">{{ old('alamat') }}</textarea>
                            @error('alamat') <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="latitude" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Latitude</label>
                                <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude') }}" required placeholder="-7.73169465" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition placeholder-gray-400 font-mono">
                                @error('latitude') <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="longitude" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Longitude</label>
                                <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude') }}" required placeholder="110.33960979" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition placeholder-gray-400 font-mono">
                                @error('longitude') <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Lokasi Rumah</label>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Klik pada peta untuk memilih lokasi rumah</p>
                            <div id="admin-map" class="h-72 w-full rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 shadow-inner"></div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-800">
                        <a href="{{ route('admin.index') }}" class="px-5 py-2.5 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">Batal</a>
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl shadow-lg shadow-blue-600/25 transition-all hover:-translate-y-0.5">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const center = [-7.7316946528213, 110.33960979406231];
            const map = L.map('admin-map', { zoomControl: true }).setView(center, 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors' }).addTo(map);
            let marker = null;
            function updateInputs(lat, lng) { document.getElementById('latitude').value = lat.toFixed(8); document.getElementById('longitude').value = lng.toFixed(8); }
            map.on('click', function (e) {
                const { lat, lng } = e.latlng;
                if (marker) map.removeLayer(marker);
                marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                updateInputs(lat, lng);
                marker.on('dragend', function (e) { const { lat, lng } = e.target.getLatLng(); updateInputs(lat, lng); });
            });
            const oldLat = parseFloat(document.getElementById('latitude').value);
            const oldLng = parseFloat(document.getElementById('longitude').value);
            if (oldLat && oldLng && !isNaN(oldLat) && !isNaN(oldLng)) {
                marker = L.marker([oldLat, oldLng], { draggable: true }).addTo(map);
                map.setView([oldLat, oldLng], 15);
                marker.on('dragend', function (e) { const { lat, lng } = e.target.getLatLng(); updateInputs(lat, lng); });
            }
        })();
    </script>
</body>
</html>