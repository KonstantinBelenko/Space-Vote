<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <script src="https://cdn.tailwindcss.com"></script>
        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>

        <div class="min-h-screen bg-gray-900 text-gray-100">

            <!-- Page Heading -->
            <a href="{{ route('home') }}">
                <header class="w-full h-16 p-4 pl-6">
                    <span class="font-bold text-xl">Space Vote</span>
                </header>
            </a>

            <div class="font-sans text-gray-900 antialiased">
                {{ $slot }}
            </div>

            @stack('modals')

            @livewireScripts

        </div>
    </body>
</html>
