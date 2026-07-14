<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Data Warga — Admin</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        :root {
            --background: 0 0% 100%;
            --foreground: 0 0% 3.6%;
            --card: 0 0% 100%;
            --card-foreground: 0 0% 3.6%;
            --muted: 0 0% 96.1%;
            --muted-foreground: 0 0% 45.1%;
            --border: 0 0% 89.8%;
            --input: 0 0% 89.8%;
            --primary: 200 100% 50%;
            --primary-foreground: 0 0% 100%;
            --radius: 0.5rem;
        }
        @media (prefers-color-scheme: dark) {
            :root {
                --background: 0 0% 3.6%;
                --foreground: 0 0% 98.2%;
                --card: 0 0% 10%;
                --card-foreground: 0 0% 98.2%;
                --muted: 0 0% 14.9%;
                --muted-foreground: 0 0% 63.9%;
                --border: 0 0% 14.9%;
                --input: 0 0% 14.9%;
                --primary: 200 100% 50%;
                --primary-foreground: 0 0% 0%;
            }
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; background: hsl(var(--background)); color: hsl(var(--foreground)); }
        .container { max-width: 800px; margin: 0 auto; padding: 2rem 1rem; }
        .card { background: hsl(var(--card)); border: 1px solid hsl(var(--border)); border-radius: var(--radius); padding: 1.5rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .flex { display: flex; align-items: center; justify-content: space-between; }
        .text-lg { font-size: 1.125rem; font-weight: 700; }
        .text-sm { font-size: 0.875rem; }
        .text-muted { color: hsl(var(--muted-foreground)); }
        label { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.25rem; }
        input, textarea {
            width: 100%; padding: 0.5rem 0.75rem; border: 1px solid hsl(var(--input));
            border-radius: var(--radius); font-size: 0.875rem; background: hsl(var(--card));
            color: hsl(var(--foreground)); font-family: inherit;
        }
        input:focus, textarea:focus { outline: none; border-color: hsl(var(--primary)); box-shadow: 0 0 0 2px hsl(var(--primary) / 0.2); }
        .btn {
            display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.5rem 1rem;
            border-radius: var(--radius); font-size: 0.875rem; font-weight: 500;
            text-decoration: none; border: 1px solid transparent; cursor: pointer;
            transition: all 0.15s; font-family: inherit;
        }
        .btn-primary { background: hsl(var(--primary)); color: hsl(var(--primary-foreground)); }
        .btn-primary:hover { opacity: 0.9; }
        .btn-outline { background: transparent; color: hsl(var(--foreground)); border-color: hsl(var(--border)); }
        .btn-outline:hover { background: hsl(var(--muted)); }
        .btn-sm { padding: 0.25rem 0.75rem; font-size: 0.75rem; }
        .error { font-size: 0.75rem; color: hsl(0 84% 60%); margin-top: 0.25rem; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .map-container { margin-top: 0.5rem; border-radius: var(--radius); overflow: hidden; border: 1px solid hsl(var(--border)); }
        #admin-map { height: 350px; width: 100%; }
        .hint { font-size: 0.75rem; color: hsl(var(--muted-foreground)); margin-top: 0.25rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="flex mb-6">
            <div>
                <div class="text-lg">Tambah Data Warga</div>
                <p class="text-sm text-muted">Klik pada peta untuk menentukan lokasi rumah</p>
            </div>
            <a href="{{ route('admin.index') }}" class="btn btn-outline btn-sm">← Kembali</a>
        </div>

        <div class="card">
            <form action="{{ route('admin.store') }}" method="POST">
                @csrf
                <div style="display:grid; gap:1.25rem;">
                    <div>
                        <label for="nama_pemilik">Nama Pemilik</label>
                        <input type="text" name="nama_pemilik" id="nama_pemilik" value="{{ old('nama_pemilik') }}" required placeholder="Nama lengkap pemilik rumah">
                        @error('nama_pemilik') <div class="error">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="2" required placeholder="Alamat lengkap rumah">{{ old('alamat') }}</textarea>
                        @error('alamat') <div class="error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-row">
                        <div>
                            <label for="latitude">Latitude</label>
                            <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude') }}" required placeholder="-7.73169465">
                            @error('latitude') <div class="error">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="longitude">Longitude</label>
                            <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude') }}" required placeholder="110.33960979">
                            @error('longitude') <div class="error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div>
                        <label>Lokasi Rumah</label>
                        <p class="hint">Klik pada peta untuk memilih lokasi rumah</p>
                        <div class="map-container">
                            <div id="admin-map"></div>
                        </div>
                    </div>
                </div>
                <div style="display:flex; gap:0.5rem; justify-content:flex-end; margin-top:1.5rem;">
                    <a href="{{ route('admin.index') }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        (function() {
            const center = [-7.7316946528213, 110.33960979406231];
            const map = L.map('admin-map', { zoomControl: true }).setView(center, 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
            }).addTo(map);

            let marker = null;

            function updateInputs(lat, lng) {
                document.getElementById('latitude').value = lat.toFixed(8);
                document.getElementById('longitude').value = lng.toFixed(8);
            }

            map.on('click', function(e) {
                const { lat, lng } = e.latlng;
                if (marker) map.removeLayer(marker);
                marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                updateInputs(lat, lng);
                marker.on('dragend', function(e) {
                    const { lat, lng } = e.target.getLatLng();
                    updateInputs(lat, lng);
                });
            });

            const oldLat = parseFloat(document.getElementById('latitude').value);
            const oldLng = parseFloat(document.getElementById('longitude').value);
            if (oldLat && oldLng && !isNaN(oldLat) && !isNaN(oldLng)) {
                marker = L.marker([oldLat, oldLng], { draggable: true }).addTo(map);
                map.setView([oldLat, oldLng], 15);
                marker.on('dragend', function(e) {
                    const { lat, lng } = e.target.getLatLng();
                    updateInputs(lat, lng);
                });
            }
        })();
    </script>
</body>
</html>