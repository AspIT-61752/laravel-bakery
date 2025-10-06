<div class="mb-4">
    <a href="{{ route('products.recipe', $post->slug) }}">
        <div class="relative w-full h-48 mb-2 rounded-lg overflow-hidden">
            <!-- Blurry background -->
            <img src="{{ asset($post->image) }}" alt=""
                class="absolute inset-0 w-full h-full object-cover filter blur-lg scale-110" />
            <!-- Main image -->
            <img src="{{ asset($post->image) }}" alt="{{ $post->name }}"
                class="relative w-full h-full object-contain object-center z-10" />
        </div>
        {{-- <img src="{{ asset($post->image) }}" alt="{{ $post->name }}"
            class="w-full h-48 object-cover object-center mb-2 rounded-lg"> --}}
        <h3 class="text-lg font-semibold">{{ $post->name }}</h3>
        <p class="text-gray-600">{{ Str::limit($post->description, 30) }}</p>
        <p class="text-gray-600">Type: {{ $post->productType->type_name }}</p>
        <p class="text-gray-600">Ingredients:
            {{ Str::limit(implode(', ', $post->ingredients->pluck('ingredient_name')->toArray()), 24) }}</p>
        <p class="text-xs text-gray-500">Created at: {{ $post->created_at->diffForHumans() }} |
            Last updated: {{ $post->updated_at->diffForHumans() }}</p>
        <p class="text-xs text-gray-500">Likes: {{ $post->likes->count() }}</p>
    </a>
</div>
