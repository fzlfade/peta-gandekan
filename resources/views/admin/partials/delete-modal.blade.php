<!-- Custom Delete Confirmation Modal Partial -->
<div 
    x-show="showDeleteModal" 
    x-cloak 
    class="fixed inset-0 z-[9999] flex items-center justify-center p-gutter overflow-y-auto"
>
    <!-- Backdrop Overlay -->
    <div 
        x-show="showDeleteModal" 
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="showDeleteModal = false" 
        class="fixed inset-0 bg-black/60 backdrop-blur-sm"
    ></div>

    <!-- Modal Dialog Card -->
    <div 
        x-show="showDeleteModal"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-surface-container-lowest border border-outline-variant rounded-2xl p-stack-lg max-w-md w-full shadow-2xl z-10 text-center space-y-4"
    >
        <div class="w-16 h-16 rounded-full bg-error-container text-on-error-container flex items-center justify-center mx-auto shadow-sm">
            <span class="material-symbols-outlined text-[36px]">warning</span>
        </div>

        <div>
            <h3 class="text-headline-md font-headline-lg text-on-background">Konfirmasi Hapus Data</h3>
            <p class="text-body-md text-on-surface-variant mt-2 leading-relaxed">
                Apakah Anda yakin ingin menghapus data warga <strong class="text-on-surface font-semibold" x-text="deleteName"></strong>? Data yang dihapus tidak dapat dikembalikan.
            </p>
        </div>

        <form :action="deleteUrl" method="POST" class="flex gap-3 pt-2">
            @csrf
            @method('DELETE')
            <button 
                type="button" 
                @click="showDeleteModal = false" 
                class="flex-1 py-2.5 px-4 bg-surface-container-low text-on-surface border border-outline-variant hover:bg-surface-container rounded-xl font-button-text text-button-text transition-colors"
            >
                Batal
            </button>
            <button 
                type="submit" 
                class="flex-1 py-2.5 px-4 bg-error text-on-error hover:bg-error/90 rounded-xl font-button-text text-button-text shadow-md transition-all flex items-center justify-center gap-1.5"
            >
                <span class="material-symbols-outlined text-[18px]">delete</span>
                Ya, Hapus
            </button>
        </form>
    </div>
</div>
