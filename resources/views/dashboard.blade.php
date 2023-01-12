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

                {{-- Submit button --}}
                <div class="flex justify-start">
                    <button type="submit" class="bg-[#ff0000] w-full text-gray-200 text-xl font-bold px-4 py-2 rounded-xl hover:bg-[#cc0000] duration-10">
                        QUIT ACCOUNT
                    </button>
                </div>
            </form>


        </div>
    </div>
</x-app-layout>
