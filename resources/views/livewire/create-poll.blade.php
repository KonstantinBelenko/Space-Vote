<div class="max-w-2xl mx-auto mt-4 px-6">

        {{-- Warning--}}
        <div class="w-full min-h-16 bg-[#f50c00] px-4 py-2 rounded-md">
            <span class="font-bold">⚠ Warning</span>
            <p class="mt-1">You wouldn't be able to change this poll after you submit it.</p>
        </div>

        {{-- Title --}}
        <div class="my-4" x-data="{ count: 0 }" x-init="count = $refs.countme.value.length">
            <label for="title" class="block text-gray-200 text-sm font-bold mb-2">Title</label>
            <input wire:model="title" x-ref="countme" x-on:keyup="count = $refs.countme.value.length" required type="text" name="title" id="title" maxlength="42" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Title">

            <span class="font-mono font-xs text-gray-400">
                <span x-html="$refs.countme.maxLength - count"></span> chars left
            </span>
        </div>

        {{-- Description --}}
        <div class="mb-4" x-data="{ count: 0 }" x-init="count = $refs.countme.value.length">
            <label for="description" class="block text-gray-200 text-sm font-bold mb-2">Description</label>
            <textarea wire:model="description" x-ref="countme" x-on:keyup="count = $refs.countme.value.length" maxlength="255" required name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Description"></textarea>

            <span class="font-mono font-xs text-gray-400">
                <span x-html="$refs.countme.maxLength - count"></span> chars left
            </span>
        </div>

        <div class="mb-4">
            <label for="type" class="block text-gray-200 text-sm font-bold mb-2">Who can See / Vote?</label>

            <div class="flex flex-col">
                <div class="flex items center mb-2">

                    <input wire:model="type" type="radio" name="type" id="anarchy" value="anarchy" class="mr-2">
                    <label for="anarchy" class="text-gray-200 text-sm font-bold">Anarchy</label>

                    <input wire:model="type" type="radio" name="type" id="public" value="public" class="mr-2 ml-4">
                    <label for="public" class="text-gray-200 text-sm font-bold">Public</label>

                    @if (Auth::user()->is_approved)
                        <input wire:model="type" type="radio" name="type" id="students" value="student" class="mr-2 ml-4">
                        <label for="students" class="text-gray-200 text-sm font-bold">Students</label>
                    @endif

                    @if (Auth::user()->is_admin)
                        <input wire:model="type" type="radio" name="type" id="admins" value="admin" class="mr-2 ml-4">
                        <label for="admins" class="text-gray-200 text-sm font-bold">Admins</label>
                    @endif

                </div>
            </div>
        </div>

        {{-- Answer options --}}
        <div>
            <label for="answers" class="block text-gray-200 text-sm font-bold mb-2">Possible answers</label>

            {{-- Add option button --}}
            <div class="flex justify-start">
                <button wire:click="addAnswer" class="border-2 border-white w-full text-gray-200 text-xl font-bold px-4 py-2 rounded-xl ">
                    Add option
                </button>
            </div>

            @foreach($answers as $key => $answer)
                <div class="mt-4 flex flex-row gap-4 items-center justify-start">

                    <input
                        wire:model="answers.{{$key}}.text"
                        type="text"
                        value="{{ $answer['text'] }}"
                        name="answers[]"
                        id="answer_{{ $key }}"

                        required
                        maxlength="22"
                        pattern="[0-9a-zA-Z_.-]*"

                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Answer {{ $key + 1 }}"
                    >

                    {{-- Show delete button if number of optional answers > 2 (required minimum) --}}
                    @if(count($answers) > 2)
                        <button wire:click="removeAnswer({{ $key }})" class="text-xl">🗑</button>
                    @endif
                </div>

            @endforeach
        </div>

        {{-- Submit button --}}
        <div class="flex justify-start mt-4">
            <button wire:click="createPoll" type="submit" class="bg-[#0066ff] w-full text-gray-200 text-xl font-bold px-4 py-2 rounded-xl hover:bg-[#0066cc] duration-10">
                Create Poll
            </button>
        </div>
</div>
