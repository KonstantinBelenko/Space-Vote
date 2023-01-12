<x-guest-layout>

    {{-- Check if poll was stopped --}}
    @if ($poll->is_open == false)
        <div class="max-w-2xl mx-auto px-6">
            <div class="bg-red-500 text-gray-100 text-center font-bold py-3 px-4 rounded">
                This poll has ended.
            </div>
        </div>
    @endif

    {{-- Display poll title --}}
    <div class="max-w-2xl mx-auto mt-12 px-6 break-all">
        <p class="text-gray-400 font-mono text-xs">Poll type - {{ $poll->type }}</p>
        <h1 class="text-3xl font-bold text-gray-100">{{ $poll->title }}</h1>
    </div>

    {{-- Display poll description --}}
    <div class="max-w-2xl break-all mx-auto mt-4 px-6">
        <p class="text-gray-400 font-mono text-xs">Description</p>
        <p class="text-gray-100">{{ $poll->description }}</p>
    </div>

    {{-- Button to delete poll if user is the creator --}}
    @auth()
        @if (Auth::user()->id == $poll->user_id && $poll->is_open == true)
            <form method="POST" action="{{ route('polls.destroy', $poll->id) }}" class="max-w-2xl mx-auto mt-6 px-6" >
                @csrf
                @method('DELETE')

                {{-- Submit button --}}
                <div class="flex justify-start">
                    <button type="submit" class="bg-[#0066ff] w-full text-gray-200 text-xl font-bold px-4 py-2 rounded-xl hover:bg-[#cc0000] duration-10">
                        STOP POLL
                    </button>
                </div>
            </form>

            @if(Auth::user()->is_admin || Auth::user()->is_owner)
                <p class="text-gray-400 font-mono text-xs mx-6 mt-4">Admin action</p>
                <form method="POST" action="{{ route('polls.destroy', $poll->id) }}" class="max-w-2xl mx-auto mt-2 px-6" >
                    @csrf
                    @method('DELETE')

                    {{-- Submit button --}}
                    <div class="flex justify-start">
                        <button type="submit" class="bg-[#ff0000] w-full text-gray-200 text-xl font-bold px-4 py-2 rounded-xl hover:bg-[#cc0000] duration-10">
                            DESTORY POLL
                        </button>
                    </div>
                </form>
            @endif

        @elseif(Auth::user()->id != $poll->user_id && (Auth::user()->is_admin || Auth::user()->is_owner))
            <p class="text-gray-400 font-mono text-xs mx-6 mt-4">Admin actions</p>

            @if($poll->is_open)
                <form method="POST" action="{{ route('polls.stop', $poll->id) }}" class="max-w-2xl mx-auto mt-2 px-6" >
                    @csrf

                    {{-- Submit button --}}
                    <div class="flex justify-start">
                        <button type="submit" class="bg-[#0066ff] w-full text-gray-200 text-xl font-bold px-4 py-2 rounded-xl hover:bg-[#cc0000] duration-10">
                            STOP POLL
                        </button>
                    </div>
                </form>
            @endif

            <form method="POST" action="{{ route('polls.destroy', $poll->id) }}" class="max-w-2xl mx-auto mt-2 px-6" >
                @csrf
                @method('DELETE')

                {{-- Submit button --}}
                <div class="flex justify-start">
                    <button type="submit" class="bg-[#ff0000] w-full text-gray-200 text-xl font-bold px-4 py-2 rounded-xl hover:bg-[#cc0000] duration-10">
                        DESTORY POLL
                    </button>
                </div>
            </form>
        @endif

    @endif


</x-guest-layout>
