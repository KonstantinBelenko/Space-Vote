<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto px-6">

            {{-- Quit user account button --}}
            <form method="POST" action="{{ route('logout') }}" class="max-w-2xl mx-auto px-6">
                @csrf

                @if(auth()->user()->is_owner)
                <div class="font-mono text-gray-400 text-xs">Account status</div>
                <p class="font-bold text-xl">🎉 Owner</p>
                @elseif(auth()->user()->is_admin)
                <div class="font-mono text-gray-400 text-xs">Account status</div>
                <p class="font-bold text-xl">🎫 Admin</p>
                @else
                <div class="font-mono text-gray-400 text-xs">Account status</div>
                <p class="font-bold text-xl">{{ auth()->user()->is_approved ? '✅ Approved' : '⏱Pending Approval' }}</p>
                @endif

                <div class="flex flex-col break-all">
                    <div class="mt-6">
                        <div class="font-mono text-gray-400 text-xs">Email</div>
                        <p class="text-xl">{{ auth()->user()->email }}</p>
                    </div>

                    <div class="mt-6">
                        <div class="font-mono text-gray-400 text-xs">Name</div>
                        <p class="text-xl">{{ auth()->user()->name }}</p>
                    </div>

                    <div class="mt-6">
                        <div class="font-mono text-gray-400 text-xs">API-KEY</div>
                        <p class="text-xl">{{ auth()->user()->api_key }}</p>
                    </div>
                </div>

                {{-- Quit account button --}}
                <div class="mt-6 flex justify-start">
                    <button type="submit" class="border-2 border-red-500 hover:border-[#FF0000] w-full text-red-500 hover:text-[#FF0000] text-xl  px-4 py-2 rounded-xl transition-all duration-300">
                        Exit acccount
                    </button>
                </div>
            </form>

            @if(!auth()->user()->rainbow)
            {{-- Get rainbow button --}}
            <form method="GET" action="{{ route('getpremium') }}" class="max-w-2xl mx-auto px-6 mt-4">
                @csrf
                <button class="border-2 border-green-500 hover:border-green-300 w-full text-green-500 hover:text-green-300 text-xl  px-4 py-2 rounded-xl transition-all duration-300">GET THE RAINBOW</button>
            </form>
            @endif

        </div>
    </div>
</x-app-layout>
