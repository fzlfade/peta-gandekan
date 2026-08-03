<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-headline-lg font-headline-lg text-on-background">Registrasi Admin</h2>
        <p class="font-body-md text-on-surface-variant mt-1">Buat akun pengelola data warga baru</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-label-md text-on-surface mb-1">Nama Lengkap</label>
            <input id="name" class="w-full bg-surface-container-low border border-outline-variant rounded px-md py-xs text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:outline-none" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-error" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-label-md text-on-surface mb-1">Email</label>
            <input id="email" class="w-full bg-surface-container-low border border-outline-variant rounded px-md py-xs text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:outline-none" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-error" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-label-md text-on-surface mb-1">Password</label>
            <input id="password" class="w-full bg-surface-container-low border border-outline-variant rounded px-md py-xs text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:outline-none" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-error" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-label-md text-on-surface mb-1">Konfirmasi Password</label>
            <input id="password_confirmation" class="w-full bg-surface-container-low border border-outline-variant rounded px-md py-xs text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:outline-none" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-error" />
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-outline-variant">
            <a class="text-sm font-label-md text-primary hover:underline" href="{{ route('login') }}">
                Sudah punya akun?
            </a>

            <button type="submit" class="bg-primary text-on-primary hover:bg-primary-container hover:text-on-primary-container px-6 py-2.5 rounded font-button-text text-button-text transition-all">
                Daftar Administrator
            </button>
        </div>
    </form>
</x-guest-layout>
