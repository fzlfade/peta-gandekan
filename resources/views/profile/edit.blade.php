<x-app-layout>
    <x-slot name="header">
        <h1 class="font-headline-lg text-headline-lg text-on-background">
            Pengaturan Profil Administrator
        </h1>
    </x-slot>

    <div class="py-stack-lg px-gutter bg-background min-h-screen">
        <div class="max-w-container-max mx-auto space-y-stack-lg">
            <div class="p-stack-lg bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-stack-lg bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-stack-lg bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
