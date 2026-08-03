<x-app-layout>
    <div class="py-stack-lg px-gutter bg-background min-h-screen">
        <div class="max-w-container-max mx-auto space-y-stack-md">
            @if (session('success'))
                <div class="p-md rounded-xl bg-tertiary-container text-on-tertiary-container border border-outline-variant text-body-md flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-headline-lg font-headline-lg text-on-background">Data Warga Gandekan</h1>
                    <p class="font-body-md text-on-surface-variant mt-1">Kelola master data rumah warga, lokasi koordinat, dan alamat</p>
                </div>
                <a href="{{ route('admin.create') }}" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg font-label-md hover:bg-primary-container hover:text-on-primary-container transition-all flex items-center gap-2 shadow-md">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    Tambah Data Warga
                </a>
            </div>

            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-outline-variant">
                        <thead>
                            <tr class="bg-surface-container-low text-on-surface">
                                <th class="px-6 py-4 text-left text-label-sm uppercase tracking-wider"># ID</th>
                                <th class="px-6 py-4 text-left text-label-sm uppercase tracking-wider">Nama Pemilik</th>
                                <th class="px-6 py-4 text-left text-label-sm uppercase tracking-wider">Alamat Lengkap</th>
                                <th class="px-6 py-4 text-left text-label-sm uppercase tracking-wider">Koordinat Peta</th>
                                <th class="px-6 py-4 text-center text-label-sm uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant bg-surface-container-lowest">
                            @forelse ($wargas as $w)
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="px-6 py-4 text-body-md text-on-surface-variant font-mono">#{{ $w->id }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-card-title text-card-title text-on-surface">{{ $w->nama_pemilik }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-body-md text-on-surface-variant max-w-xs truncate">{{ $w->alamat }}</td>
                                    <td class="px-6 py-4">
                                        <div class="text-label-xs text-on-surface-variant font-mono bg-surface-container-low px-2 py-1 rounded inline-block">
                                            <div>Lat: {{ round($w->latitude, 6) }}</div>
                                            <div>Lng: {{ round($w->longitude, 6) }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.edit', $w) }}" class="px-3 py-1.5 text-label-sm bg-secondary-container text-on-secondary-container hover:bg-secondary-fixed-dim rounded transition-colors inline-flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[16px]">edit</span>
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.destroy', $w) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data warga ini?')" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 text-label-sm bg-error-container text-on-error-container hover:bg-error/20 rounded transition-colors inline-flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <span class="material-symbols-outlined text-[48px] text-on-surface-variant opacity-40">person_search</span>
                                            <p class="text-on-surface-variant font-card-title">Belum ada data warga yang tersimpan</p>
                                            <a href="{{ route('admin.create') }}" class="text-primary font-label-md hover:underline inline-flex items-center gap-1 mt-2">
                                                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                                                Tambah Data Warga Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($wargas->hasPages())
                <div class="mt-6">
                    {{ $wargas->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>