<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto px-6">

            {{-- Quit user account button --}}
            <form method="POST" action="{{ route('logout') }}" class="max-w-2xl mx-auto px-6" >
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

                <div class="flex flex-column gap-6">
                    <div class="mt-6">
                        <div class="font-mono text-gray-400 text-xs">Email</div>
                        <p class="text-xl">{{ auth()->user()->email }}</p>
                    </div>

                    <div class="mt-6">
                        <div class="font-mono text-gray-400 text-xs">Name</div>
                        <p class="text-xl">{{ auth()->user()->name }}</p>
                    </div>
                </div>

                {{-- Quit account button --}}
                <div class="mt-6 flex justify-start">
                    <button type="submit" class="bg-[#ff0000] w-full text-gray-200 text-xl font-bold px-4 py-2 rounded-xl hover:bg-[#cc0000] duration-10">
                        QUIT ACCOUNT
                    </button>
                </div>
            </form>


        </div>
    </div>
</x-app-layout>
