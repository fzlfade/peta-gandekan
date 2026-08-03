<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peta Warga Gandekan | Community Portal</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300..900;1,300..900&family=Atkinson+Hyperlegible+Next:ital,wght@0,200..800;1,200..800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Leaflet & App Styles -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-on-surface font-body-md overflow-hidden h-screen flex flex-col">
    <!-- TopNavBar -->
    <header class="fixed top-0 left-0 w-full h-[64px] z-50 flex justify-between items-center px-md bg-surface-container-lowest border-b border-outline-variant shadow-sm">
        <div class="flex items-center gap-md">
            <a href="/" class="text-headline-lg font-headline-lg text-primary font-bold tracking-tight">Peta Warga Gandekan</a>
        </div>
        <!-- Search Bar -->
        <div class="hidden md:flex flex-1 max-w-xl mx-xl relative items-center">
            <span class="material-symbols-outlined absolute left-md text-on-surface-variant pointer-events-none">search</span>
            <input id="search" oninput="filterResidents(this.value)" class="w-full bg-surface-container-low border border-outline-variant rounded px-xl py-xs pl-[48px] focus:ring-2 focus:ring-primary focus:outline-none text-body-md text-on-surface" placeholder="Cari Nama Warga atau Alamat..." type="text"/>
        </div>
        <div class="flex items-center gap-md">
            <a href="/" class="p-2 hover:bg-surface-container-low transition-colors rounded-full text-on-surface-variant flex items-center gap-1 font-label-md text-sm">
                <span class="material-symbols-outlined text-[20px]">home</span>
                <span class="hidden sm:inline">Beranda</span>
            </a>
            @auth
                <a href="{{ url('/dashboard') }}" class="p-2 hover:bg-surface-container-low transition-colors rounded-full text-on-surface-variant flex items-center gap-1 font-label-md text-sm">
                    <span class="material-symbols-outlined text-[20px]">dashboard</span>
                    <span class="hidden sm:inline">Dashboard</span>
                </a>
            @else
                <a href="{{ url('/login') }}" class="p-2 hover:bg-surface-container-low transition-colors rounded-full text-on-surface-variant flex items-center gap-1 font-label-md text-sm">
                    <span class="material-symbols-outlined text-[20px]">account_circle</span>
                    <span class="hidden sm:inline">Admin Login</span>
                </a>
            @endauth
        </div>
    </header>

    <!-- Main Content Area: Sidebar + Map -->
    <main class="flex flex-1 mt-[64px] relative h-[calc(100vh-64px)]">
        <!-- Sidebar -->
        <aside class="w-full md:w-[30%] min-w-[320px] md:min-w-[360px] md:max-w-[420px] bg-surface-container-lowest border-r border-outline-variant flex flex-col z-40 overflow-hidden shadow-sm">
            <!-- Mobile Search Bar -->
            <div class="p-sm md:hidden border-b border-outline-variant bg-surface-container-low">
                <div class="relative items-center flex">
                    <span class="material-symbols-outlined absolute left-md text-on-surface-variant pointer-events-none">search</span>
                    <input oninput="filterResidents(this.value)" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-xl py-xs pl-[48px] focus:ring-2 focus:ring-primary focus:outline-none text-body-md text-on-surface" placeholder="Cari Nama Warga atau Alamat..." type="text"/>
                </div>
            </div>

            <!-- Filters / Header -->
            <div class="p-md border-b border-outline-variant bg-surface-container-low flex justify-between items-center shrink-0">
                <div>
                    <h2 class="text-card-title font-card-title text-on-surface">Data Warga Gandekan</h2>
                    <p class="text-label-xs text-on-surface-variant" id="resident-count-label">Klik kartu untuk navigasi peta</p>
                </div>
                @auth
                    <a href="{{ route('admin.create') }}" class="bg-primary-container text-on-primary-container px-md py-xs rounded font-button-text text-button-text hover:bg-[#EAB308] transition-colors flex items-center gap-xs">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        Tambah
                    </a>
                @endauth
            </div>

            <!-- Resident Card List (Scrollable) -->
            <div id="resident-list" class="flex-1 overflow-y-auto custom-scrollbar p-sm space-y-sm"></div>
        </aside>

        <!-- Right Map Area -->
        <section class="flex-1 relative bg-surface-dim overflow-hidden h-full">
            <div id="map" class="w-full h-full"></div>
        </section>
    </main>

    <script>
        const map = L.map('map').setView([-7.7316946528213, 110.33960979406231], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        const residents = @json($residents);
        const markers = [];
        let selectedResidentId = null;

        function buildList(data) {
            const list = document.getElementById('resident-list');
            const countLabel = document.getElementById('resident-count-label');
            countLabel.textContent = `${data.length} rumah warga terdata`;

            if (data.length === 0) {
                list.innerHTML = `
                    <div class="p-xl text-center text-on-surface-variant">
                        <span class="material-symbols-outlined text-[36px] block mx-auto mb-2 opacity-50">search_off</span>
                        <p class="font-label-md">Tidak ada data warga yang cocok.</p>
                    </div>
                `;
                return;
            }

            list.innerHTML = data.map(r => {
                const isActive = selectedResidentId === r.id;
                const cardClass = isActive 
                    ? 'bg-surface-container border-l-4 border-primary p-md cursor-pointer transition-all hover:bg-surface-container-high group border-t border-b border-r border-outline-variant rounded-r' 
                    : 'bg-surface-container-lowest border-l-4 border-outline-variant p-md cursor-pointer transition-all hover:bg-surface-container-low border border-outline-variant rounded-r';
                
                const iconClass = isActive ? 'text-primary' : 'text-on-surface-variant opacity-30';

                return `
                    <div class="${cardClass}" onclick="focusResident(${r.latitude}, ${r.longitude}, ${r.id})">
                        <div class="flex justify-between items-start">
                            <div class="overflow-hidden">
                                <p class="text-card-title font-card-title text-on-surface truncate">${r.nama_pemilik}</p>
                                <p class="text-body-md text-on-surface-variant truncate mt-xs">${r.alamat}</p>
                            </div>
                            <span class="material-symbols-outlined ${iconClass} shrink-0 ml-2">location_on</span>
                        </div>
                        <div class="mt-sm flex flex-wrap gap-xs items-center">
                            <span class="px-xs py-[2px] bg-surface-variant text-on-surface-variant text-label-xs rounded">Rumah Warga</span>
                            <a class="px-xs py-[2px] bg-secondary-container text-on-secondary-container text-label-xs rounded inline-flex items-center gap-1 hover:bg-secondary-fixed-dim transition-colors ml-auto" href="https://www.google.com/maps/dir/?api=1&destination=${r.latitude},${r.longitude}" target="_blank" rel="noopener" onclick="event.stopPropagation()">
                                <span class="material-symbols-outlined text-[14px]">near_me</span>
                                Navigasi
                            </a>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function focusResident(lat, lng, id) {
            selectedResidentId = id;
            buildList(residents);
            map.flyTo([lat, lng], 18, { animate: true, duration: 1.0 });
            markers.forEach(m => {
                if (m.options.residentId === id) {
                    setTimeout(() => m.openPopup(), 300);
                }
            });
        }

        function filterResidents(query) {
            const q = query.toLowerCase();
            const filtered = residents.filter(r => 
                r.nama_pemilik.toLowerCase().includes(q) || 
                r.alamat.toLowerCase().includes(q)
            );
            buildList(filtered);
        }

        residents.forEach(r => {
            const m = L.marker([r.latitude, r.longitude]);
            m.options.residentId = r.id;
            m.addTo(map);
            
            m.bindPopup(`
                <div class="bg-surface-container-lowest w-[280px] p-md">
                    <h3 class="text-card-title font-card-title text-on-surface flex items-center gap-xs">
                        <span class="material-symbols-outlined text-primary text-[18px]">location_on</span>
                        ${r.nama_pemilik}
                    </h3>
                    <p class="text-body-md text-on-surface-variant mt-xs">${r.alamat}</p>
                    <div class="mt-md flex gap-sm">
                        <a href="https://www.google.com/maps/dir/?api=1&destination=${r.latitude},${r.longitude}" target="_blank" rel="noopener" class="flex-1 bg-secondary-container text-on-secondary-container px-md py-xs rounded font-button-text text-button-text hover:bg-secondary-fixed-dim transition-colors flex justify-center items-center gap-xs text-decoration-none">
                            <span class="material-symbols-outlined text-[18px]">near_me</span>
                            Rute Navigasi
                        </a>
                    </div>
                </div>
            `);

            m.on('click', () => {
                selectedResidentId = r.id;
                buildList(residents);
            });

            markers.push(m);
        });

        buildList(residents);
    </script>
</body>
</html>