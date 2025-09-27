<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $post->name }}
        </h2>
    </x-slot>

    <div class="py-8 mt-2">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between">
                        <div>
                            {{-- Should be #303030 --}}
                            <h2 class="text-2xl font-semibold ">{{ $post->name }}</h2>
                            {{-- This should be #9a9a9a but I might be able to just use TailWind colors --}}
                            <h3 class="text-lg font-semibold">{{ $post->productType->type_name }}</h3>
                        </div>
                        <x-primary-button class="mt-2 mb-4">
                            <p>♥ Like button here</p>
                        </x-primary-button>
                    </div>
                    {{-- pt-4 or py-4, not really sure yet. But I like how pt-4 looks --}}
                    <div class="flex justify-between pt-4">
                        <div>
                            <img src="{{ $post->image }}" alt="{{ $post->name }}"
                                class="w-full h-48 object-cover mb-2 rounded-lg">
                            <p class="text-gray-600 flex">{{ $post->description }}</p>
                            <p class="mt-4">{{ $post->recipe }}</p>
                        </div>
                        <div class=" max-w-6xl min-w-2xl">
                            <h3 class="text-lg font-bold">{{ __('Ingredients') }}</h3>
                            @foreach ($post->ingredients as $ingredient)
                                <x-ingredient-tabs :ingredient="$ingredient" />
                            @endforeach
                        </div>
                    </div>
                    {{-- This I think it looks better here, but I'm unsure if it's "necessary" --}}
                    <p class="text-xs text-gray-500 mt-4">Created at: {{ $post->created_at->diffForHumans() }} |
                        Last updated: {{ $post->updated_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
        <div class="mt-4 max-w-6xl mx-auto sm:px-6 lg:px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @auth
                        <form action="{{ route('products.comments.submit', $post->id) }}" method="POST" class="mb-4">
                            @csrf
                            <label for="body" class="block mb-2">Leave a comment,
                                {{ Auth::user()->name }}:</label>
                            <textarea name="body" id="body" rows="2"
                                class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200" required></textarea>
                            <div class="flex justify-between">
                                {{-- Added the div as an error container so the error and max characters stay consistent --}}
                                <div>
                                    @error('body')
                                        <p class="text-red-500 text-sm">Error: <span>{{ $message }}</span></p>
                                    @enderror
                                </div>
                                <p class="text-gray-500 text-sm">Max 1000 characters</p>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Post
                                    Comment</button>
                            </div>
                        </form>
                    @else
                        <p class="text-gray-500">Login to make a comment</p>
                    @endauth
                    <div class="mt-6">
                        <h4 class="text-md font-semibold mb-2">Comments for {{ $post->name }}</h4>
                        @forelse ($post->comments as $comment)
                            <div class="mb-4 p-3 border rounded-lg bg-gray-100">
                                <div class="flex items-start">
                                    {{-- Profile image, uses the pear as the default pfp --}}
                                    <img src="{{ $comment->user->profile_image ? $comment->user->profile_image : asset('default/pear.png') }}"
                                        alt="{{ $comment->user->name }}" class="w-12 h-12 rounded-full mr-2" />
                                    {{-- 12 looks like it's the same size as the name and comment text --}}
                                    <div>
                                        <div class="flex items-center mb-1">
                                            <span
                                                class="font-bold text-gray-800 mr-2">{{ $comment->user->name }}</span>
                                            <span
                                                class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-700">{{ $comment->body }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-600">No comments yet. Be the first to comment!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="mt-4 max-w-6xl mx-auto sm:px-6 lg:px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p>New card starts here</p>
                </div>
            </div>
        </div> --}}
    </div>
</x-app-layout>
