<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- {{ dd($posts) }} --}}
                    @foreach ($posts as $post)
                        <div class="mb-4">
                            <a href="{{ route('products.recipe', $post->slug) }}">
                                <h3 class="text-lg font-semibold">{{ $post->name }}</h3>
                                <p class="text-gray-600">{{ $post->description }}</p>
                                <p class="text-gray-600">Type: {{ $post->productType->type_name }}</p>
                                <p class="text-gray-600">Ingredients:
                                    {{ implode(', ', $post->ingredients->pluck('ingredient_name')->toArray()) }}</p>
                                <p class="text-xs text-gray-500">Created at: {{ $post->created_at->diffForHumans() }} |
                                    Last updated: {{ $post->updated_at->diffForHumans() }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
