<div class="p-6 bg-white border-b border-gray-200 grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
    @foreach ($posts as $post)
        <x-recipe-card :post="$post" />
    @endforeach
</div>
