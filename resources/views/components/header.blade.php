<header class="w-full h-16 p-4 pl-6 flex flex-row justify-between items-center">
    <a href="{{ route('home') }}" class="font-bold text-xl">🌑 Space Vote</a>

    <div class="flex flex-col items-top justify-center items-center py-4 ">
        @if (Route::has('login'))
            <div class="top-0 right-0 px-6 py-4 block">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-gray-500 font-mono">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-500 font-mono">Log in</a>
                    /
                    <a href="{{ route('register') }}" class="text-sm text-gray-500 font-mono">Register</a>
                @endauth
            </div>
        @endif

        @if(isset($weather))
            {{ $weather->weather[0]->main }} | {{ $weather->main->temp }}°C
        @endif

    </div>
</header>
