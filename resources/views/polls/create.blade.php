<x-app-layout>

    <form method="POST" action="{{ route('polls.store') }}" class="max-w-2xl mx-auto mt-16 px-6" >
        @csrf

        <div class="mb-4" x-data="{ count: 0 }" x-init="count = $refs.countme.value.length">

            <label for="title" class="block text-gray-200 text-sm font-bold mb-2">Title</label>
            <input x-ref="countme" x-on:keyup="count = $refs.countme.value.length" required type="text" name="title" id="title" maxlength="32" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Title">

            <span class="font-mono font-xs text-gray-400">
                <span x-html="$refs.countme.maxLength - count"></span> chars left
            </span>
        </div>

        <div class="mb-4" x-data="{ count: 0 }" x-init="count = $refs.countme.value.length">
            <label for="description" class="block text-gray-200 text-sm font-bold mb-2">Description</label>
            <textarea x-ref="countme" x-on:keyup="count = $refs.countme.value.length" maxlength="255" required name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Description"></textarea>

            <span class="font-mono font-xs text-gray-400">
                <span x-html="$refs.countme.maxLength - count"></span> chars left
            </span>
        </div>

        <div class="mb-4">
            <label for="type" class="block text-gray-200 text-sm font-bold mb-2">Who can vote?</label>

            <div class="flex flex-col">
                <div class="flex items center mb-2">

                    <input checked="checked" type="radio" name="type" id="public" value="public" class="mr-2">
                    <label for="public" class="text-gray-200 text-sm font-bold">Public</label>

                    @if (Auth::user()->is_approved)
                        <input type="radio" name="type" id="students" value="student" class="mr-2 ml-4">
                        <label for="students" class="text-gray-200 text-sm font-bold">Students</label>
                    @endif

                    @if (Auth::user()->is_admin)
                        <input type="radio" name="type" id="admins" value="admin" class="mr-2 ml-4">
                        <label for="admins" class="text-gray-200 text-sm font-bold">Admins</label>
                    @endif

                </div>
            </div>
        </div>

        {{-- Submit button --}}
        <div class="flex justify-start">
            <button type="submit" class="bg-[#0066ff] w-full text-gray-200 text-xl font-bold px-4 py-2 rounded-xl hover:bg-[#0066cc] duration-10">
                Create Poll
            </button>
        </div>
    </form>

</x-app-layout>
