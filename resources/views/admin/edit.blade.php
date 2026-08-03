<x-app-layout>
    <div class="py-stack-lg px-gutter bg-background min-h-screen">
        <div class="max-w-2xl mx-auto space-y-stack-md">
            <div>
                <a href="{{ route('admin.index') }}" class="text-body-md text-on-surface-variant hover:text-primary transition-colors inline-flex items-center gap-1 mb-2 font-label-md">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Kembali ke Data Warga
                </a>
                <h1 class="text-headline-lg font-headline-lg text-on-background">Edit Data Warga</h1>
                <p class="font-body-md text-on-surface-variant">Perbarui informasi pemilik, alamat, dan titik lokasi koordinat di peta</p>
            </div>

            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm p-stack-lg">
                <form action="{{ route('admin.update', $warga) }}" method="POST" class="space-y-6">
                    @csrf @method('PUT')
                    <div>
                        <label for="nama_pemilik" class="block font-label-md text-on-surface mb-2">Nama Pemilik Rumah</label>
                        <input type="text" name="nama_pemilik" id="nama_pemilik" value="{{ old('nama_pemilik', $warga->nama_pemilik) }}" required class="w-full bg-surface-container-low border border-outline-variant rounded px-md py-xs focus:ring-2 focus:ring-primary focus:outline-none text-body-md text-on-surface">
                        @error('nama_pemilik') <p class="mt-1 text-xs text-error font-label-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="alamat" class="block font-label-md text-on-surface mb-2">Alamat Rumah</label>
                        <textarea name="alamat" id="alamat" rows="3" required class="w-full bg-surface-container-low border border-outline-variant rounded px-md py-xs focus:ring-2 focus:ring-primary focus:outline-none text-body-md text-on-surface">{{ old('alamat', $warga->alamat) }}</textarea>
                        @error('alamat') <p class="mt-1 text-xs text-error font-label-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="latitude" class="block font-label-md text-on-surface mb-2">Latitude</label>
                            <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude', $warga->latitude) }}" required class="w-full bg-surface-container-low border border-outline-variant rounded px-md py-xs focus:ring-2 focus:ring-primary focus:outline-none text-body-md text-on-surface font-mono">
                            @error('latitude') <p class="mt-1 text-xs text-error font-label-sm">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="longitude" class="block font-label-md text-on-surface mb-2">Longitude</label>
                            <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude', $warga->longitude) }}" required class="w-full bg-surface-container-low border border-outline-variant rounded px-md py-xs focus:ring-2 focus:ring-primary focus:outline-none text-body-md text-on-surface font-mono">
                            @error('longitude') <p class="mt-1 text-xs text-error font-label-sm">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block font-label-md text-on-surface mb-1">Lokasi Rumah di Peta</label>
                        <p class="text-xs text-on-surface-variant mb-3">Geser marker atau klik peta untuk menyesuaikan titik koordinat.</p>
                        <div id="admin-map" class="h-72 w-full rounded-lg overflow-hidden border border-outline-variant shadow-inner"></div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant">
                        <a href="{{ route('admin.index') }}" class="px-6 py-2.5 border border-outline-variant text-on-surface hover:bg-surface-container-low rounded font-button-text text-button-text transition-colors">Batal</a>
                        <button type="submit" class="px-6 py-2.5 bg-primary text-on-primary hover:bg-primary-container hover:text-on-primary-container rounded font-button-text text-button-text shadow-md transition-all">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Leaflet JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const lat = parseFloat(document.getElementById('latitude').value);
            const lng = parseFloat(document.getElementById('longitude').value);
            const map = L.map('admin-map').setView([lat, lng], 16);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(map);
            let marker = L.marker([lat, lng], { draggable: true }).addTo(map);

            function updateInputs(lat, lng) {
                document.getElementById('latitude').value = lat.toFixed(8);
                document.getElementById('longitude').value = lng.toFixed(8);
            }

            marker.on('dragend', function (e) {
                const { lat, lng } = e.target.getLatLng();
                updateInputs(lat, lng);
            });

            map.on('click', function (e) {
                const { lat, lng } = e.latlng;
                map.removeLayer(marker);
                marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                updateInputs(lat, lng);
                marker.on('dragend', function (e) {
                    const { lat, lng } = e.target.getLatLng();
                    updateInputs(lat, lng);
                });
            });
        });
    </script>
</x-app-layout>