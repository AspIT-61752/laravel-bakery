<div class="mb-4">
    <a href="{{ route('products.recipe', $post->slug) }}">
        <img src="{{ $post->image }}" alt="{{ $post->name }}" class="w-full h-48 object-cover mb-2 rounded-lg">
        <h3 class="text-lg font-semibold">{{ $post->name }}</h3>
        <p class="text-gray-600">{{ $post->description }}</p>
        <p class="text-gray-600">Type: {{ $post->productType->type_name }}</p>
        <p class="text-gray-600">Ingredients:
            {{ implode(', ', $post->ingredients->pluck('ingredient_name')->toArray()) }}</p>
        <p class="text-xs text-gray-500">Created at: {{ $post->created_at->diffForHumans() }} |
            Last updated: {{ $post->updated_at->diffForHumans() }}</p>
    </a>
</div>
