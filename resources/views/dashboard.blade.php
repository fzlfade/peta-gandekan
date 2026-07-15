<x-app-layout>
    <div class="bg-white dark:bg-gray-950">
        <!-- Hero Header -->
        <section class="relative overflow-hidden pt-12 pb-20 px-6 text-center">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-500 dark:from-gray-900 dark:to-gray-950 pointer-events-none"></div>
            <div class="max-w-3xl mx-auto relative">
                <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-cyan-600">
                    Dashboard
                </h1>
                <p class="mt-4 text-lg md:text-xl text-gray-900 dark:text-gray-100">Selamat datang, {{ Auth::user()->name }}!</p>
                <a href="{{ route('admin.index') }}" class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-lg shadow-blue-600/25 transition-all hover:-translate-y-0.5">
                    Kelola Data Warga
                </a>
            </div>
        </section>

        <div class="py-10 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <!-- Total Warga Card -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Total Warga</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Warga::count() }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Peta Card -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/50 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Peta Interaktif</p>
                                <a href="{{ url('/peta') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">Lihat Peta</a>
                            </div>
                        </div>
                    </div>
                    <!-- Admin Card -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/50 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Admin</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Aksi Cepat</h3>
                    </div>
                    <div class="p-6 grid md:grid-cols-2 gap-4">
                        <a href="{{ route('admin.create') }}" class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-900 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/20 border border-gray-200 dark:border-gray-700 hover:border-blue-400 transition-all group">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                            </div>
                            <div>
                                <p class="font-medium text-sm text-gray-900 dark:text-white">Tambah Data Warga</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Masukkan data rumah warga baru</p>
                            </div>
                        </a>
                        <a href="{{ route('admin.index') }}" class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-900 rounded-xl hover:bg-indigo-50 dark:hover:bg-indigo-900/20 border border-gray-200 dark:border-gray-700 hover:border-indigo-400 transition-all group">
                            <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
                            </div>
                            <div>
                                <p class="font-medium text-sm text-gray-900 dark:text-white">Lihat Semua Data</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Kelola dan edit data warga</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>