<x-app-layout>
    <div class="py-stack-lg px-gutter bg-background min-h-screen">
        <div class="max-w-2xl mx-auto space-y-stack-md">
            <div>
                <a href="{{ route('admin.index') }}" class="text-body-md text-on-surface-variant hover:text-primary transition-colors inline-flex items-center gap-1 mb-2 font-label-md">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Kembali ke Data Warga
                </a>
                <h1 class="text-headline-lg font-headline-lg text-on-background">Tambah Data Warga Baru</h1>
                <p class="font-body-md text-on-surface-variant">Lengkapi form dan klik lokasi rumah di peta untuk mendapatkan koordinat</p>
            </div>

            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm p-stack-lg">
                <form action="{{ route('admin.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="nama_pemilik" class="block font-label-md text-on-surface mb-2">Nama Pemilik Rumah</label>
                        <input type="text" name="nama_pemilik" id="nama_pemilik" value="{{ old('nama_pemilik') }}" required placeholder="Nama lengkap pemilik..." class="w-full bg-surface-container-low border border-outline-variant rounded px-md py-xs focus:ring-2 focus:ring-primary focus:outline-none text-body-md text-on-surface">
                        @error('nama_pemilik') <p class="mt-1 text-xs text-error font-label-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="alamat" class="block font-label-md text-on-surface mb-2">Alamat Rumah</label>
                        <textarea name="alamat" id="alamat" rows="3" required placeholder="Alamat lengkap (RT/RW)..." class="w-full bg-surface-container-low border border-outline-variant rounded px-md py-xs focus:ring-2 focus:ring-primary focus:outline-none text-body-md text-on-surface">{{ old('alamat') }}</textarea>
                        @error('alamat') <p class="mt-1 text-xs text-error font-label-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="latitude" class="block font-label-md text-on-surface mb-2">Latitude</label>
                            <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude') }}" required placeholder="-7.73169465" class="w-full bg-surface-container-low border border-outline-variant rounded px-md py-xs focus:ring-2 focus:ring-primary focus:outline-none text-body-md text-on-surface font-mono">
                            @error('latitude') <p class="mt-1 text-xs text-error font-label-sm">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="longitude" class="block font-label-md text-on-surface mb-2">Longitude</label>
                            <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude') }}" required placeholder="110.33960979" class="w-full bg-surface-container-low border border-outline-variant rounded px-md py-xs focus:ring-2 focus:ring-primary focus:outline-none text-body-md text-on-surface font-mono">
                            @error('longitude') <p class="mt-1 text-xs text-error font-label-sm">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block font-label-md text-on-surface mb-1">Pilih Lokasi di Peta</label>
                        <p class="text-xs text-on-surface-variant mb-3">Klik pada peta di bawah ini untuk menentukan titik koordinat lokasi rumah.</p>
                        <div id="admin-map" class="h-72 w-full rounded-lg overflow-hidden border border-outline-variant shadow-inner"></div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant">
                        <a href="{{ route('admin.index') }}" class="px-6 py-2.5 border border-outline-variant text-on-surface hover:bg-surface-container-low rounded font-button-text text-button-text transition-colors">Batal</a>
                        <button type="submit" class="px-6 py-2.5 bg-primary text-on-primary hover:bg-primary-container hover:text-on-primary-container rounded font-button-text text-button-text shadow-md transition-all">Simpan Data Warga</button>
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
            const defaultCenter = [-7.7316946528213, 110.33960979406231];
            const map = L.map('admin-map').setView(defaultCenter, 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(map);
            let marker = null;

            function updateInputs(lat, lng) {
                document.getElementById('latitude').value = lat.toFixed(8);
                document.getElementById('longitude').value = lng.toFixed(8);
            }

            map.on('click', function (e) {
                const { lat, lng } = e.latlng;
                if (marker) map.removeLayer(marker);
                marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                updateInputs(lat, lng);
                marker.on('dragend', function (e) {
                    const { lat, lng } = e.target.getLatLng();
                    updateInputs(lat, lng);
                });
            });

            const oldLat = parseFloat(document.getElementById('latitude').value);
            const oldLng = parseFloat(document.getElementById('longitude').value);
            if (oldLat && oldLng && !isNaN(oldLat) && !isNaN(oldLng)) {
                marker = L.marker([oldLat, oldLng], { draggable: true }).addTo(map);
                map.setView([oldLat, oldLng], 16);
                marker.on('dragend', function (e) {
                    const { lat, lng } = e.target.getLatLng();
                    updateInputs(lat, lng);
                });
            }
        });
    </script>
</x-app-layout>