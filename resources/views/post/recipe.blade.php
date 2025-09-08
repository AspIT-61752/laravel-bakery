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
    </div>
</x-app-layout>
