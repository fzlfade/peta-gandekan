<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — Peta Warga Gandekan</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300..900;1,300..900&family=Atkinson+Hyperlegible+Next:ital,wght@0,200..800;1,200..800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen font-body-md antialiased bg-background text-on-surface">
    <div class="min-h-screen flex">
        <!-- Left Panel -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-inverse-surface p-12 flex-col justify-between overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-on-primary">
                        <span class="material-symbols-outlined text-[24px]">location_on</span>
                    </div>
                    <span class="text-surface-bright text-xl font-bold font-headline-lg tracking-tight">Peta Warga Gandekan</span>
                </div>
                <p class="text-surface-variant opacity-80 text-sm">Portal Administrasi Data Geografis</p>
            </div>

            <div class="relative z-10">
                <blockquote class="text-surface-bright text-3xl font-headline-lg font-bold leading-snug mb-4">
                    Kelola data pemetaan warga<br>dengan mudah & akurat.
                </blockquote>
                <p class="text-surface-variant opacity-80 text-body-md leading-relaxed max-w-md">
                    Sistem Pemetaan Digital Desa Kalurahan Gandekan untuk kemudahan visualisasi lokasi dan administrasi kependudukan.
                </p>
            </div>

            <div class="relative z-10 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center text-xs font-bold">KKN</div>
                <div>
                    <p class="text-surface-bright text-sm font-label-md">KKN Tlogoadi 2026</p>
                    <p class="text-surface-variant opacity-60 text-xs">Kalurahan Gandekan · Sleman</p>
                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="flex-1 flex items-center justify-center px-6 py-12">
            <div class="w-full max-w-sm">
                <div class="flex items-center gap-3 mb-8 lg:hidden">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-on-primary">
                        <span class="material-symbols-outlined text-[24px]">location_on</span>
                    </div>
                    <span class="font-bold text-xl font-headline-lg text-primary">Peta Warga Gandekan</span>
                </div>

                <h1 class="text-headline-lg font-headline-lg text-on-background mb-1">Selamat Datang</h1>
                <p class="text-on-surface-variant text-body-md mb-8">Masuk ke akun administrator</p>

                @if (session('status'))
                    <div class="mb-4 p-md rounded-xl bg-tertiary-container text-on-tertiary-container text-sm font-label-md">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-label-md text-on-surface mb-1.5">Email Administrator</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@admin.com" class="w-full bg-surface-container-low border border-outline-variant rounded px-md py-xs text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:outline-none {{ $errors->has('email') ? 'border-error' : '' }}">
                        @error('email') <p class="mt-1 text-xs text-error font-label-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-label-md text-on-surface">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-primary hover:underline font-label-sm">Lupa password?</a>
                            @endif
                        </div>
                        <input type="password" name="password" id="password" required autocomplete="current-password" placeholder="••••••••" class="w-full bg-surface-container-low border border-outline-variant rounded px-md py-xs text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:outline-none {{ $errors->has('password') ? 'border-error' : '' }}">
                        @error('password') <p class="mt-1 text-xs text-error font-label-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="remember_me" name="remember" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                            <span class="text-body-md text-on-surface-variant select-none">Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full py-3 px-4 bg-primary hover:bg-primary-container hover:text-on-primary-container text-on-primary font-button-text text-button-text rounded shadow-md transition-all">
                        Masuk Administrator
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-outline-variant text-center">
                    <a href="{{ url('/') }}" class="text-body-md text-on-surface-variant hover:text-primary transition-colors inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>