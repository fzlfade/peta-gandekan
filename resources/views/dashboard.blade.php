<x-app-layout>
    <div class="py-stack-lg px-gutter bg-background min-h-screen">
        <div class="max-w-container-max mx-auto space-y-stack-lg">
            <!-- Welcome Header -->
            <div class="bg-surface-container-lowest p-stack-lg rounded-xl border border-outline-variant shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-secondary-container text-on-secondary-container rounded-full text-label-sm uppercase tracking-wider mb-2">
                        <span class="material-symbols-outlined text-[16px]">admin_panel_settings</span>
                        Portal Administrasi
                    </div>
                    <h1 class="font-headline-lg text-headline-lg text-on-background">Selamat Datang, {{ Auth::user()->name }}!</h1>
                    <p class="font-body-md text-on-surface-variant mt-1">Kelola data pemetaan rumah warga Kalurahan Gandekan dengan aman dan efisien.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.create') }}" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg font-label-md hover:bg-primary-container hover:text-on-primary-container transition-all flex items-center gap-2 shadow-md">
                        <span class="material-symbols-outlined text-[20px]">add</span>
                        Tambah Warga
                    </a>
                    <a href="{{ url('/peta') }}" class="bg-surface-container-low text-primary border border-outline-variant px-6 py-2.5 rounded-lg font-label-md hover:bg-surface-container transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">map</span>
                        Buka Peta
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                <!-- Total Warga Card -->
                <div class="bg-surface-container-lowest border border-outline-variant p-stack-lg rounded-xl shadow-sm hover:border-primary transition-all group">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-surface-container rounded-lg flex items-center justify-center group-hover:bg-primary group-hover:text-on-primary transition-colors">
                            <span class="material-symbols-outlined text-[32px] text-primary group-hover:text-on-primary">people</span>
                        </div>
                        <div>
                            <p class="text-label-sm text-on-surface-variant uppercase tracking-wider">Total Rumah Warga</p>
                            <p class="font-headline-lg text-display-lg-mobile text-primary font-bold">{{ \App\Models\Warga::count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Peta Card -->
                <div class="bg-surface-container-lowest border border-outline-variant p-stack-lg rounded-xl shadow-sm hover:border-primary transition-all group">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-surface-container rounded-lg flex items-center justify-center group-hover:bg-primary group-hover:text-on-primary transition-colors">
                            <span class="material-symbols-outlined text-[32px] text-primary group-hover:text-on-primary">location_searching</span>
                        </div>
                        <div>
                            <p class="text-label-sm text-on-surface-variant uppercase tracking-wider">Peta Interaktif</p>
                            <a href="{{ url('/peta') }}" class="font-headline-md text-headline-md text-primary hover:underline inline-flex items-center gap-1">
                                Lihat Peta <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Admin Card -->
                <div class="bg-surface-container-lowest border border-outline-variant p-stack-lg rounded-xl shadow-sm hover:border-primary transition-all group">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-surface-container rounded-lg flex items-center justify-center group-hover:bg-primary group-hover:text-on-primary transition-colors">
                            <span class="material-symbols-outlined text-[32px] text-primary group-hover:text-on-primary">account_circle</span>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-label-sm text-on-surface-variant uppercase tracking-wider">Akun Login</p>
                            <p class="font-headline-md text-card-title text-on-surface truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden">
                <div class="p-md border-b border-outline-variant bg-surface-container-low flex justify-between items-center">
                    <h3 class="font-headline-md text-headline-md text-on-background flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">space_dashboard</span>
                        Menu Manajemen
                    </h3>
                </div>
                <div class="p-stack-lg grid grid-cols-1 md:grid-cols-2 gap-gutter">
                    <a href="{{ route('admin.create') }}" class="flex items-center gap-4 p-md bg-surface-container-low rounded-xl border border-outline-variant hover:border-primary hover:bg-surface-container transition-all group">
                        <div class="w-12 h-12 bg-primary text-on-primary rounded-lg flex items-center justify-center group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-[28px]">add_location_alt</span>
                        </div>
                        <div>
                            <p class="font-headline-md text-card-title text-on-surface">Tambah Data Warga Baru</p>
                            <p class="text-body-md text-on-surface-variant">Input nama pemilik, alamat, dan pin koordinat peta</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.index') }}" class="flex items-center gap-4 p-md bg-surface-container-low rounded-xl border border-outline-variant hover:border-primary hover:bg-surface-container transition-all group">
                        <div class="w-12 h-12 bg-secondary text-on-secondary rounded-lg flex items-center justify-center group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-[28px]">list_alt</span>
                        </div>
                        <div>
                            <p class="font-headline-md text-card-title text-on-surface">Kelola Master Data Warga</p>
                            <p class="text-body-md text-on-surface-variant">Lihat daftar lengkap, edit data, atau hapus entry</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>