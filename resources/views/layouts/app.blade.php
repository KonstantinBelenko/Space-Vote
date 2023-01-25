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

        <!-- Styles -->
        @livewireStyles
        <style>
            .wrapper {
                background: linear-gradient(124deg, #ff2400, #e81d1d, #e8b71d, #e3e81d, #1de840, #1ddde8, #2b1de8, #dd00f3, #dd00f3);
                background-size: 1800% 1800%;

                -webkit-animation: rainbow 18s ease infinite;
                -z-animation: rainbow 18s ease infinite;
                -o-animation: rainbow 18s ease infinite;
                animation: rainbow 18s ease infinite;}

            @-webkit-keyframes rainbow {
                0%{background-position:0% 82%}
                50%{background-position:100% 19%}
                100%{background-position:0% 82%}
            }
            @-moz-keyframes rainbow {
                0%{background-position:0% 82%}
                50%{background-position:100% 19%}
                100%{background-position:0% 82%}
            }
            @-o-keyframes rainbow {
                0%{background-position:0% 82%}
                50%{background-position:100% 19%}
                100%{background-position:0% 82%}
            }
            @keyframes rainbow {
                0%{background-position:0% 82%}
                50%{background-position:100% 19%}
                100%{background-position:0% 82%}
            }
        </style>
    </head>
    <body class="{{ (auth()->check() && auth()->user()->rainbow) ? "font-sans antialiased wrapper text-gray-100" : "font-sans antialiased bg-gray-900 text-gray-100" }}">

        <div class="min-h-screen text-gray-100">

            {{-- Header --}}
            <x-header />

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
