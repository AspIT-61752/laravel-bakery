<div class="p-6 bg-white border-b border-gray-200">
    @foreach ($posts as $post)
        <x-recipe-card :post="$post" />
    @endforeach
</div>
