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
        <header class="w-full h-16 p-4 pl-6">
            <span class="font-bold text-xl">🌑 Space Vote</span>
            <div class="relative flex items-top justify-center items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="fixed top-0 right-0 px-6 py-4 block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-500 font-mono">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-500 font-mono">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-500 font-mono">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            </div>
        </header>

        {{-- Content --}}
        <div class="max-w-full mx-auto">

            {{-- List Polls --}}
            <div class="max-w-full mx-auto mt-12 mb-12">
                <div class="mt-4">
                    {{-- Check if there is more then 0 polls --}}
                    @if (count($polls) > 0)
                        @foreach ($polls as $poll)
                            <div class="bg-gray-800 hover:bg-gray-700 transition-all duration-300 min-h-[64px] mt-4 px-6 py-4 border-white border-2 rounded-md mx-6">
                                <a href="{{ route('polls.show', $poll) }}">
                                    <h2 class="text-xl font-bold text-gray-100 break-words">{{ substr($poll->title, 0, 42) }}</h2>
                                    <p class="mt-1 text-gray-300 break-all">{{ substr($poll->description, 0, 108) }}...</p>
                                    <p class="mt-1 text-gray-400 font-mono text-xs" title="{{ $poll->created_at }}">{{ $poll->created_at->diffForHumans() }}</p>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="bg-gray-800 min-h-[64px] mt-4 px-6 py-4 border-white border-2 rounded-md mx-6">
                            <h2 class="text-2xl font-bold text-gray-100 truncate">No active polls found</h2>
                            <p class="mt-1 text-gray-300 break-all">There are no polls available at this time.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Create Poll Button --}}
        @auth
            <a href="{{ route('polls.create') }}" class="fixed bg-[#0066ff] min-w-[128px] text-gray-200 text-xl font-bold px-6 py-4 right-8 bottom-8 rounded-xl hover:scale-110 duration-100">
                Create Poll
            </a>
        @else
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="fixed bg-[#0066ff] min-w-[128px] text-gray-200 text-xl font-bold px-6 py-4 right-8 bottom-8 rounded-xl hover:scale-110 duration-100">
                    Register To Vote
                </a>
            @endif
        @endif

    </body>
</html>
