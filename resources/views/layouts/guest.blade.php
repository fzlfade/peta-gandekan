<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Peta Warga Gandekan') }}</title>

        <!-- Fonts & Icons -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300..900;1,300..900&family=Atkinson+Hyperlegible+Next:ital,wght@0,200..800;1,200..800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-body-md bg-background text-on-surface antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-background px-gutter">
            <div class="mb-4 text-center">
                <a href="/" class="text-headline-lg font-headline-lg text-primary font-bold tracking-tight inline-flex items-center gap-2">
                    <span class="material-symbols-outlined text-[32px] text-primary">location_on</span>
                    Peta Warga Gandekan
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-4 px-stack-lg py-stack-lg bg-surface-container-lowest border border-outline-variant shadow-xl rounded-xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
