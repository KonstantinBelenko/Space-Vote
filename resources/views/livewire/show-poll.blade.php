<div>
    {{-- Check if poll was stopped --}}
    @if ($poll->is_open == false)
        <div class="max-w-2xl mx-auto px-6">
            <div class="bg-red-500 text-gray-100 text-center font-bold py-3 px-4 rounded">
                This poll has ended.
            </div>
        </div>
    @endif

    <div class="max-w-2xl mx-auto my-2 px-6 break-words">
        <p class="flex justify-between text-gray-400 font-mono text-xs">Votes: {{ $poll->nVoted() }}</p>
    </div>

    @if( $poll->nVoted() > 0 )
        <div class="text-white">
            <livewire:votes-chart :poll="$poll" />
        </div>
    @endif

    {{-- Display poll title --}}
    <div class="max-w-2xl mx-auto mt-6 px-6 break-words">

        <p class="flex justify-between text-gray-400 font-mono text-xs">
            <span>Poll type: <span class="underline">{{ ucfirst($poll->type) }}</span></span>
            <span title="{{ $poll->created_at }}">{{ $poll->created_at->diffForHumans() }}</span>
        </p>

        <h1 class="text-2xl font-bold text-gray-100">{{ $poll->title }}</h1>
    </div>

    {{-- Display poll description --}}
    <div class="max-w-2xl break-all mx-auto mt-4 px-6 break-words">
        <p class="text-gray-400 font-mono text-xs">Description</p>
        <p class="text-gray-100">{{ $poll->description }}</p>
    </div>

    {{-- Voting --}}
    <div class="max-w-2xl break-all mx-auto mt-4 mb-8 px-6">
        <div class="flex flex-col justify-between text-xl text-white">

            {{-- Check if this poll is anarchical --}}
            @if ($poll->type == 'anarchy')
                <div>

                    @if(!$hasVoted)
                        <p class="text-gray-400 font-mono text-xs mb-2">Vote</p>

                        @foreach($poll->answers()->get() as $key => $answer)
                            <div class="w-full mb-4">

                                <input type="hidden" name="vote" value="{{ $answer->id }}">
                                <input type="hidden" name="anonymous" value="1">
                                <button wire:click="vote({{ $answer->id }})" type="submit" class="font-bold bg-white text-gray-900 hover:bg-gray-900 border-2 border-white rounded-xl w-full py-2 hover:text-white transition-all duration-300">
                                    {{ $answer->text }}
                                </button>
                            </div>
                        @endforeach

                    @else

                        <p class="text-gray-400 font-mono text-xs mb-2">You already voted</p>
                        @foreach($poll->answers()->get() as $key => $answer)
                            <form method="POST" action="{{ route('polls.vote', $poll) }}" class="w-full mb-4">
                                @csrf

                                {{-- Voting blocks (highting the one the user voted for --}}
                                @if($answer->text == $poll->answers()->where('id', $userVote)->first()->text)

                                    <button class="font-bold bg-[#0066ff] border-2 border-white rounded-xl w-full py-2 text-white transition-all duration-300">
                                        {{ $answer->text }}
                                    </button>

                                @else

                                    <button class="font-bold bg-gray-900 border-2 border-white rounded-xl w-full py-2 text-white transition-all duration-300">
                                        {{ $answer->text }}
                                    </button>

                                @endif

                            </form>
                        @endforeach

                    @endif
                </div>
            @else

                @if(!$poll->hasVoted(auth()->user()))
                    <p class="text-gray-400 font-mono text-xs mb-2">Vote</p>
                    @foreach($poll->answers()->get() as $key => $answer)
                        <form method="POST" action="{{ route('polls.vote', $poll->uuid) }}" class="w-full mb-4">
                            @csrf
                            <input type="hidden" name="vote" value="{{ $answer->id }}">
                            <input type="hidden" name="anonymous" value="1">
                            <button type="submit" class="font-bold bg-white text-gray-900 hover:bg-gray-900 border-2 border-white rounded-xl w-full py-2 hover:text-white transition-all duration-300">
                                {{ $answer->text }}
                            </button>
                        </form>
                    @endforeach

                @else
                    <p class="text-gray-400 font-mono text-xs mb-2">You already voted</p>
                    @foreach($poll->answers()->get() as $key => $answer)
                        <div class="w-full mb-4">

                            {{-- Voting blocks (highting the one the user voted for --}}
                            @if($answer->text == $poll->userAnswer(auth()->user())->text)

                                <button class="font-bold bg-[#0066ff] border-2 border-white rounded-xl w-full py-2 text-white transition-all duration-300">
                                    {{ $answer->text }}
                                </button>

                            @else

                                <button class="font-bold bg-gray-900 border-2 border-white rounded-xl w-full py-2 text-white transition-all duration-300">
                                    {{ $answer->text }}
                                </button>

                            @endif

                        </div>
                    @endforeach

                @endif
            @endif

            {{-- Share button --}}
            <script>
                function share() {
                    if (navigator.share) {
                        navigator.share({
                            title: 'Share the poll',
                            url: window.location.href
                        }).then(() => {
                            console.log('Thanks for sharing!');
                        })
                            .catch(console.error);
                    } else {
                        // fallback
                    }
                }
            </script>
            <div>
                <p class="text-gray-400 font-mono text-xs mb-2 underline flex justify-between">
                    <button onclick="share()" class="underline">Share</button>
                    <button onclick="qr()" class="underline">QR</button>
                </p>
            </div>

        </div>
    </div>

    {{-- QR Code modal --}}
    <div id="modal-bg" class="top-0 bottom-0 left-0 right-0 absolute w-full h-full bg-black/50"></div>
    <div id="qr-code" class="absolute top-0 bottom-0 left-0 right-0 mx-auto my-auto w-fit h-fit p-6 bg-white rounded-md ">
        <a href="{{ 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$currentHref }}" target="_blank">
            <img src={{ 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$currentHref }} />
        </a>
    </div>
    <script>

        // Set modal-bg to display none on load & on click
        document.getElementById('modal-bg').style.display = 'none';
        document.getElementById('qr-code').style.display = 'none';

        document.getElementById('modal-bg').addEventListener('click', function() {
            document.getElementById('modal-bg').style.display = 'none';
            document.getElementById('qr-code').style.display = 'none';
        });

        function qr() {
            document.getElementById('modal-bg').style.display = 'block';
            document.getElementById('qr-code').style.display = 'block';
        }

    </script>

    {{-- Button to delete poll if user is the creator --}}
    @auth()
        @if (Auth::user()->id == $poll->user_id && $poll->is_open == true)
            <form method="POST" action="{{ route('polls.stop', $poll->uuid) }}" class="max-w-2xl mx-auto mt-6 px-6" >
                @csrf

                {{-- Submit button --}}
                <div class="flex justify-start">
                    <button type="submit" class="border-2 border-blue-500 hover:border-[#0066ff] w-full text-blue-500 hover:text-[#0066ff] text-xl px-4 py-2 rounded-xl transition-all duration-300">
                        Stop poll
                    </button>
                </div>
            </form>

            @if(Auth::user()->is_admin || Auth::user()->is_owner)
                <form method="POST" action="{{ route('polls.destroy', $poll->uuid) }}" class="max-w-2xl mx-auto mt-2 mb-8 px-6" >
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
                <form method="POST" action="{{ route('polls.stop', $poll->uuid) }}" class="max-w-2xl mx-auto px-6" >
                    @csrf

                    {{-- Submit button --}}
                    <div class="flex justify-start">
                        <button type="submit" class="border-2 border-blue-500 hover:border-[#0066ff] w-full text-blue-500 hover:text-[#0066ff] text-xl px-4 py-2 rounded-xl transition-all duration-300">
                            Stop poll
                        </button>
                    </div>
                </form>
            @endif

            <form method="POST" action="{{ route('polls.destroy', $poll->uuid) }}" class="max-w-2xl mx-auto mt-2 mb-8 px-6" >
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

</div>
