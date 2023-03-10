<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Space Vote</title>
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
        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://cdn.tailwindcss.com"></script>

    </head>

    <body class="{{ (auth()->check() && auth()->user()->rainbow) ? "wrapper antialiased text-gray-100" : 'antialiased bg-gray-900 text-gray-100' }}">

        {{-- Header --}}
        <x-header :weather="$weather" />

        {{-- Content --}}
        <div class="max-w-full mx-auto">

            {{-- List Polls --}}
            <div class="max-w-full mx-auto mt-12 mb-12">
                <div class="mt-4">
                    {{-- Check if there is more then 0 polls --}}
                    @if (count($polls) > 0)
                        @foreach ($polls as $poll)
                            <div class="bg-gray-800 hover:bg-gray-700 transition-all duration-300 min-h-[64px] mt-4 px-6 py-4 border-white border-2 rounded-md mx-6">
                                <a href="{{ route('polls.show', $poll->uuid) }}">
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
                    Register To Make a Poll
                </a>
            @endif
        @endif

    </body>
</html>
