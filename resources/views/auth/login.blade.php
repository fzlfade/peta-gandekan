<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — Rumah Kita Gandekan</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen font-sans antialiased bg-gray-50 dark:bg-gray-950">
    <div class="min-h-screen flex">

        {{-- Left panel --}}
        <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-blue-600 via-indigo-700 to-cyan-600 p-12 flex-col justify-between overflow-hidden">
            <div class="absolute -top-20 -left-20 w-80 h-80 bg-white/5 rounded-full"></div>
            <div class="absolute top-40 -right-16 w-64 h-64 bg-white/5 rounded-full"></div>
            <div class="absolute -bottom-16 left-20 w-96 h-96 bg-white/5 rounded-full"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                        </svg>
                    </div>
                    <span class="text-white text-xl font-bold tracking-tight">Rumah Kita Gandekan</span>
                </div>
                <p class="text-blue-200 text-sm">Panel Admin</p>
            </div>

            <div class="relative z-10">
                <blockquote class="text-white/90 text-3xl font-bold leading-snug mb-4">
                    Kelola data warga<br>dengan mudah & akurat.
                </blockquote>
                <p class="text-blue-200/80 text-sm leading-relaxed max-w-sm">
                    Platform pemetaan digital untuk visualisasi sebaran rumah warga Gandekan, Tlogoadi — berbasis peta interaktif.
                </p>
            </div>

            <div class="relative z-10 flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center text-white text-xs font-bold backdrop-blur-sm">KKN</div>
                <div>
                    <p class="text-white text-sm font-medium">KKN Tlogoadi 2026</p>
                    <p class="text-blue-300/70 text-xs">Universitas Tidar · Mlati · Sleman</p>
                </div>
            </div>
        </div>

        {{-- Right panel --}}
        <div class="flex-1 flex items-center justify-center px-6 py-12">
            <div class="w-full max-w-sm">
                <div class="flex items-center gap-3 mb-10 lg:hidden">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">Rumah Kita Gandekan</span>
                </div>

                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Selamat datang</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mb-8">Masuk ke panel admin</p>

                @if (session('status'))
                    <div class="mb-4 px-4 py-3 rounded-xl bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-200 text-sm">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@admin.com" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 text-sm text-gray-900 dark:text-white placeholder-gray-400 bg-white dark:bg-gray-800 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('email') ? 'border-red-400' : '' }}">
                        @error('email') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">Lupa password?</a>
                            @endif
                        </div>
                        <input type="password" name="password" id="password" required autocomplete="current-password" placeholder="••••••••" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 text-sm text-gray-900 dark:text-white placeholder-gray-400 bg-white dark:bg-gray-800 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('password') ? 'border-red-400' : '' }}">
                        @error('password') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="remember_me" name="remember" class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500 bg-white dark:bg-gray-800">
                            <span class="text-sm text-gray-600 dark:text-gray-400 select-none">Ingat saya</span>
                        </label>
                    </div>
                    <button type="submit" class="w-full py-2.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium text-sm rounded-xl shadow-lg shadow-blue-600/25 transition-all hover:-translate-y-0.5">
                        Masuk
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
                    <a href="{{ url('/') }}" class="text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors inline-flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>