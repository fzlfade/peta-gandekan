<nav x-data="{ open: false }" class="bg-surface-container-lowest border-b border-outline-variant shadow-sm sticky top-0 z-50 h-[64px] flex items-center">
    <div class="max-w-container-max mx-auto px-gutter w-full">
        <div class="flex justify-between items-center h-full">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="text-headline-lg font-headline-lg text-primary font-bold tracking-tight">
                    Peta Warga Gandekan
                </a>
                <div class="hidden sm:flex items-center gap-2">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-body-md font-label-md">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.*')" class="text-body-md font-label-md">
                        Data Warga
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-4">
                <a href="{{ url('/') }}" class="text-on-surface-variant hover:text-primary transition-colors text-body-md font-label-md">Beranda</a>
                <a href="{{ url('/peta') }}" class="text-on-surface-variant hover:text-primary transition-colors text-body-md font-label-md">Peta</a>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-on-surface bg-surface-container-low hover:bg-surface-container transition-colors border border-outline-variant font-label-md text-sm">
                            <div class="w-7 h-7 rounded-full bg-primary text-on-primary flex items-center justify-center text-xs font-bold">{{ substr(Auth::user()->name, 0, 1) }}</div>
                            <span>{{ Auth::user()->name }}</span>
                            <span class="material-symbols-outlined text-[18px]">expand_more</span>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">person</span>
                                {{ __('Profile') }}
                            </div>
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                <div class="flex items-center gap-2 text-error">
                                    <span class="material-symbols-outlined text-[18px]">logout</span>
                                    {{ __('Log Out') }}
                                </div>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container-low transition-colors">
                    <span class="material-symbols-outlined" x-text="open ? 'close' : 'menu'">menu</span>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden absolute top-[64px] left-0 w-full bg-surface-container-lowest border-b border-outline-variant shadow-lg">
        <div class="px-4 py-3 bg-surface-container-low border-b border-outline-variant">
            <div class="font-bold text-on-surface">{{ Auth::user()->name }}</div>
            <div class="text-xs text-on-surface-variant">{{ Auth::user()->email }}</div>
        </div>
        <div class="pt-2 pb-3 space-y-1 px-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.*')">
                Data Warga
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/')">
                Beranda
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/peta')">
                Peta
            </x-responsive-nav-link>
        </div>
        <div class="pt-4 pb-2 border-t border-outline-variant px-2">
            <x-responsive-nav-link :href="route('profile.edit')">
                {{ __('Profile') }}
            </x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>
