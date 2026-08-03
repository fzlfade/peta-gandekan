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
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md overflow-hidden h-screen flex flex-col" x-data="{ drawerOpen: false, listMobileOpen: false, selectedResident: null }">
    <!-- TopNavBar -->
    <header class="fixed top-0 left-0 w-full h-[64px] z-[9999] flex justify-between items-center px-gutter bg-surface-container-lowest border-b border-outline-variant shadow-sm">
        <div class="flex items-center gap-sm">
            <button @click="drawerOpen = !drawerOpen" class="md:hidden p-2 rounded-full hover:bg-surface-container-low transition-colors active:scale-95 text-on-surface">
                <span class="material-symbols-outlined text-[24px]">menu</span>
            </button>
            <a href="/" class="text-headline-lg font-headline-lg text-primary font-bold tracking-tight text-lg md:text-2xl">Peta Warga Gandekan</a>
        </div>

        <!-- Desktop Search Bar -->
        <div class="hidden md:flex flex-1 max-w-xl mx-xl relative items-center">
            <span class="material-symbols-outlined absolute left-md text-on-surface-variant pointer-events-none">search</span>
            <input id="search-desktop" oninput="filterResidents(this.value)" class="w-full bg-surface-container-low border border-outline-variant rounded px-xl py-xs pl-[48px] focus:ring-2 focus:ring-primary focus:outline-none text-body-md text-on-surface" placeholder="Cari Nama Warga atau Alamat..." type="text"/>
        </div>

        <div class="flex items-center gap-2">
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

    <!-- Floating Search Bar for Mobile (Shifted to clear Leaflet zoom + / - controls) -->
    <div class="md:hidden fixed top-[74px] left-[56px] right-3 max-w-[260px] sm:max-w-xs z-[9990]">
        <div class="bg-surface-container-lowest rounded-full shadow-lg border border-outline-variant flex items-center px-3 py-1 gap-1.5">
            <span class="material-symbols-outlined text-outline text-[18px]">search</span>
            <input id="search-mobile" oninput="filterResidents(this.value)" class="bg-transparent border-none focus:ring-0 w-full text-xs text-on-surface placeholder-on-surface-variant focus:outline-none py-1" placeholder="Cari warga..." type="text"/>
            <button @click="listMobileOpen = !listMobileOpen" class="p-1 rounded-full text-primary hover:bg-surface-container-low shrink-0">
                <span class="material-symbols-outlined text-[18px]">format_list_bulleted</span>
            </button>
        </div>
    </div>

    <!-- Floating Toggle Button for Mobile List Drawer -->
    <button @click="listMobileOpen = !listMobileOpen" class="md:hidden fixed bottom-6 right-6 z-[9990] bg-primary text-on-primary shadow-2xl rounded-full px-5 py-3 font-label-md flex items-center gap-2 active:scale-95 transition-all">
        <span class="material-symbols-outlined text-[20px]" x-text="listMobileOpen ? 'map' : 'list'">list</span>
        <span x-text="listMobileOpen ? 'Buka Peta' : 'Daftar Warga'">Daftar Warga</span>
    </button>

    <!-- Drawer Overlay -->
    <div x-show="drawerOpen || listMobileOpen" x-cloak @click="drawerOpen = false; listMobileOpen = false" class="fixed inset-0 bg-black/50 z-[9995] transition-opacity"></div>

    <!-- Main Content Area: Sidebar + Map -->
    <main class="flex flex-1 mt-[64px] relative h-[calc(100vh-64px)]">
        <!-- Sidebar (Desktop & Mobile Drawer) -->
        <aside 
            :class="(drawerOpen || listMobileOpen) ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
            class="fixed md:relative top-0 md:top-0 left-0 h-full md:h-full w-[85%] sm:w-[360px] md:w-[30%] min-w-[320px] md:min-w-[360px] md:max-w-[420px] bg-surface-container-lowest border-r border-outline-variant flex flex-col z-[9999] md:z-40 overflow-hidden shadow-2xl md:shadow-sm transition-transform duration-300 ease-in-out"
        >
            <!-- Filters / Header -->
            <div class="p-md border-b border-outline-variant bg-surface-container-low flex justify-between items-center shrink-0">
                <div>
                    <h2 class="text-card-title font-card-title text-on-surface">Data Warga Gandekan</h2>
                    <p class="text-label-xs text-on-surface-variant" id="resident-count-label">Klik kartu untuk navigasi peta</p>
                </div>
                <div class="flex items-center gap-2">
                    @auth
                        <a href="{{ route('admin.create') }}" class="bg-primary-container text-on-primary-container px-3 py-1.5 rounded font-button-text text-button-text hover:bg-[#EAB308] transition-colors flex items-center gap-xs">
                            <span class="material-symbols-outlined text-[18px]">add</span>
                            Tambah
                        </a>
                    @endauth
                    <button @click="drawerOpen = false; listMobileOpen = false" class="md:hidden p-1 text-on-surface-variant hover:text-on-surface">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>
            </div>

            <!-- Resident Card List (Scrollable) -->
            <div id="resident-list" class="flex-1 overflow-y-auto custom-scrollbar p-sm space-y-sm"></div>
        </aside>

        <!-- Right Map Area -->
        <section class="flex-1 relative bg-surface-dim overflow-hidden h-full w-full">
            <div id="map" class="w-full h-full min-h-full"></div>
        </section>

        <!-- Mobile Bottom Sheet Details -->
        <div 
            x-show="selectedResident !== null"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-y-full"
            x-transition:enter-end="translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-y-0"
            x-transition:leave-end="translate-y-full"
            class="md:hidden fixed bottom-0 left-0 w-full z-[9999] bg-surface-container-lowest rounded-t-[24px] shadow-[0_-8px_32px_rgba(0,0,0,0.25)] border-t border-outline-variant p-gutter"
        >
            <div class="w-12 h-1 bg-outline-variant rounded-full mx-auto mb-4"></div>
            <template x-if="selectedResident">
                <div>
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="text-headline-lg font-headline-lg text-on-surface text-xl" x-text="selectedResident.nama_pemilik"></h3>
                            <p class="text-body-md text-on-surface-variant mt-0.5 text-sm" x-text="selectedResident.alamat"></p>
                        </div>
                        <button @click="selectedResident = null" class="p-1 rounded-full hover:bg-surface-container-low text-on-surface-variant">
                            <span class="material-symbols-outlined text-[20px]">close</span>
                        </button>
                    </div>
                    <div class="mt-4 flex gap-3">
                        <a 
                            :href="`https://www.google.com/maps/dir/?api=1&destination=${selectedResident.latitude},${selectedResident.longitude}`" 
                            target="_blank" 
                            rel="noopener" 
                            class="flex-1 bg-secondary-container text-on-secondary-container py-3 px-4 rounded-xl font-button-text text-button-text hover:bg-secondary-fixed-dim transition-colors flex justify-center items-center gap-2 text-decoration-none shadow-sm"
                        >
                            <span class="material-symbols-outlined text-[18px]">near_me</span>
                            Rute Navigasi Google Maps
                        </a>
                    </div>
                </div>
            </template>
        </div>
    </main>

    <script>
        const map = L.map('map', { zoomControl: true }).setView([-7.7316946528213, 110.33960979406231], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        const residents = @json($residents);
        const markers = [];

        let selectedResidentId = null;

        function getSelectedResidentId() {
            try {
                if (window.Alpine && document.body && Alpine.$data(document.body)) {
                    return Alpine.$data(document.body).selectedResident?.id ?? selectedResidentId;
                }
            } catch (e) {}
            return selectedResidentId;
        }

        function updateSelectedResident(resident) {
            selectedResidentId = resident ? resident.id : null;
            try {
                if (window.Alpine && document.body && Alpine.$data(document.body)) {
                    Alpine.$data(document.body).selectedResident = resident;
                    if (!resident) {
                        Alpine.$data(document.body).listMobileOpen = false;
                        Alpine.$data(document.body).drawerOpen = false;
                    }
                }
            } catch (e) {}
        }

        function buildList(data) {
            const list = document.getElementById('resident-list');
            const countLabel = document.getElementById('resident-count-label');
            if (countLabel) countLabel.textContent = `${data.length} rumah warga terdata`;

            if (!list) return;

            if (data.length === 0) {
                list.innerHTML = `
                    <div class="p-xl text-center text-on-surface-variant">
                        <span class="material-symbols-outlined text-[36px] block mx-auto mb-2 opacity-50">search_off</span>
                        <p class="font-label-md">Tidak ada data warga yang cocok.</p>
                    </div>
                `;
                return;
            }

            const activeId = getSelectedResidentId();

            list.innerHTML = data.map(r => {
                const isActive = activeId === r.id;
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
                            <!-- <span class="px-xs py-[2px] bg-surface-variant text-on-surface-variant text-label-xs rounded">Rumah Cihuy</span> -->
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
            const resident = residents.find(r => r.id === id);
            updateSelectedResident(resident);
            try {
                if (window.Alpine && document.body && Alpine.$data(document.body)) {
                    Alpine.$data(document.body).listMobileOpen = false;
                    Alpine.$data(document.body).drawerOpen = false;
                }
            } catch (e) {}

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
            // Sync search inputs
            const desktopInput = document.getElementById('search-desktop');
            const mobileInput = document.getElementById('search-mobile');
            if (desktopInput && desktopInput.value !== query) desktopInput.value = query;
            if (mobileInput && mobileInput.value !== query) mobileInput.value = query;

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
                updateSelectedResident(r);
                buildList(residents);
            });

            markers.push(m);
        });

        // Initialize resident list
        buildList(residents);
        document.addEventListener('DOMContentLoaded', () => buildList(residents));
    </script>
</body>
</html>