<x-guest-layout>

    {{-- Check if poll was stopped --}}
    @if ($poll->is_open == false)
        <div class="max-w-2xl mx-auto px-6">
            <div class="bg-red-500 text-gray-100 text-center font-bold py-3 px-4 rounded">
                This poll has ended.
            </div>
        </div>
    @endif

    {{-- Positive vs Negative votes circle chart --}}
    @php
        $positive_votes = $poll->positiveVotes();
        $negative_votes = $poll->negativeVotes();
        $total_votes = $positive_votes + $negative_votes;
    @endphp

    @if($total_votes > 0)
    <div class="flex justify-center">
        <canvas id="myChart" style="width:100%;max-width:300px"></canvas>
    </div>
    @endif

    <script>
        var xValues = ["Yes", "No"];
        var yValues = [{{$positive_votes}}, {{$negative_votes}}];
        var barColors = [
            "#0066ff",
            "#ff0000",
        ];

        new Chart("myChart", {
            type: "doughnut",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                title: {
                    display: false,
                    text: "Voting chart"
                }
            }
        });
    </script>


    {{-- Display poll title --}}
    <div class="max-w-2xl mx-auto mt-6 px-6 break-words">

        <p class="flex justify-between text-gray-400 font-mono text-xs">
            <span>Poll type - {{ $poll->type }}</span>
            <span>{{ $poll->created_at->diffForHumans() }} | {{ $poll->created_at }}</span>
        </p>

        <h1 class="text-2xl font-bold text-gray-100">{{ $poll->title }}</h1>
    </div>

    {{-- Display poll description --}}
    <div class="max-w-2xl break-all mx-auto mt-4 px-6 break-words">
        <p class="text-gray-400 font-mono text-xs">Description</p>
        <p class="text-gray-100">{{ $poll->description }}</p>
    </div>

    {{-- Voting --}}
    <div class="max-w-2xl break-all mx-auto mt-4 px-6 ">
        <p class="text-gray-400 font-mono text-xs mb-2">Vote</p>
        <div class="flex flex-row justify-between gap-4 text-xl">
            @if(!$poll->hasVoted(auth()->user()))
            <form method="POST" action="{{ route('polls.vote', $poll->id) }}" class="w-full">
                @csrf
                <input type="hidden" name="vote" value="1">
                <input type="hidden" name="anonymous" value="1">
                <button type="submit" class="font-bold bg-white text-gray-900 hover:bg-gray-900 border-2 border-white rounded-xl w-full py-2 hover:text-white transition-all duration-300">
                    YES
                </button>
            </form>
            <form method="POST" action="{{ route('polls.vote', $poll->id) }}" class="w-full">
                @csrf
                <input type="hidden" name="vote" value="0">
                <input type="hidden" name="anonymous" value="1">
                <button type="submit" class="font-bold bg-white text-gray-900 hover:bg-gray-900 border-2 border-white rounded-xl w-full py-2 hover:text-white transition-all duration-300">
                    NO
                </button>
            </form>
            @else
                <div class="font-bold flex justify-center bg-gray-900 border-2 border-white rounded-xl w-full py-2 px-1 text-white transition-all duration-300">
                    You have already voted: {{ $poll->userVote(auth()->user())->vote ? 'YES' : 'NO' }}
                </div>
            @endif
        </div>
    </div>

    {{-- Button to delete poll if user is the creator --}}
    @auth()
        @if (Auth::user()->id == $poll->user_id && $poll->is_open == true)
            <form method="POST" action="{{ route('polls.stop', $poll->id) }}" class="max-w-2xl mx-auto mt-6 px-6" >
                @csrf

                {{-- Submit button --}}
                <div class="flex justify-start">
                    <button type="submit" class="border-2 border-blue-500 hover:border-[#0066ff] w-full text-blue-500 hover:text-[#0066ff] text-xl px-4 py-2 rounded-xl transition-all duration-300">
                        Stop poll
                    </button>
                </div>
            </form>

            @if(Auth::user()->is_admin || Auth::user()->is_owner)
                <form method="POST" action="{{ route('polls.destroy', $poll->id) }}" class="max-w-2xl mx-auto mt-2 px-6" >
                    <p class="text-gray-400 font-mono text-xs mx-auto mb-2 mt-4">Admin action</p>
                    @csrf
                    @method('DELETE')

                    {{-- Submit button --}}
                    <div class="flex justify-start">
                        <button type="submit" class="border-2 border-red-500 hover:border-[#FF0000] w-full text-red-500 hover:text-[#FF0000] text-xl  px-4 py-2 rounded-xl transition-all duration-300">
                            Destroy poll
                        </button>
                    </div>
                </form>
            @endif

        @elseif(Auth::user()->is_admin || Auth::user()->is_owner)
            <div class="max-w-2xl mx-auto">
                <p class="text-gray-400 font-mono text-xs mx-6 mt-4 mb-2">Admin actions</p>
            </div>

            @if($poll->is_open)
                <form method="POST" action="{{ route('polls.stop', $poll->id) }}" class="max-w-2xl mx-auto px-6" >
                    @csrf

                    {{-- Submit button --}}
                    <div class="flex justify-start">
                        <button type="submit" class="border-2 border-blue-500 hover:border-[#0066ff] w-full text-blue-500 hover:text-[#0066ff] text-xl px-4 py-2 rounded-xl transition-all duration-300">
                            Stop poll
                        </button>
                    </div>
                </form>
            @endif

            <form method="POST" action="{{ route('polls.destroy', $poll->id) }}" class="max-w-2xl mx-auto mt-2 px-6" >
                @csrf
                @method('DELETE')

                {{-- Submit button --}}
                <div class="flex justify-start">
                    <button type="submit" class="border-2 border-red-500 hover:border-[#FF0000] w-full text-red-500 hover:text-[#FF0000] text-xl  px-4 py-2 rounded-xl transition-all duration-300">
                        Destroy poll
                    </button>
                </div>
            </form>
        @endif

    @endif

</x-guest-layout>
