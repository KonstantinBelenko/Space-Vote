<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Space Vote</title>

        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://cdn.tailwindcss.com"></script>

    </head>
    <body class="antialiased bg-gray-900 text-gray-100">

        {{-- Header --}}
        <header class="fixed w-full h-16 p-4 pl-6">
            <span class="font-bold text-xl">Space Vote</span>
            <div class="relative flex items-top justify-center min-h-screen items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="fixed top-0 right-0 px-6 py-4 block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-500 underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            </div>
        </header>

            <div class="max-w-full mx-auto">

            </div>
        </div>
    </body>
</html>
