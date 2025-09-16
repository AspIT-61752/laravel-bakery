@php
    // Error handling for the user, probably a little bit slower but it's better UX. It tells the user that something went wrong.
$title = $title ?? 'Error: No title provided.';
$content = $content ?? 'Error: No content provided.';
$url = $url ?? 'Error: No URL provided.';
@endphp

<div>
    <div class="max-w-sm rounded overflow-hidden shadow-lg my-4">
        <div class="px-6 py-4">
            <div class="font-bold text-xl mb-2">{{ $title }}</div>
            <p class="text-gray-700 text-base">
                {{ $content }}
            </p>
        </div>
        <div class="px-6 py-4">
            <a href="{{ $url }}"
                class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Go</a>
        </div>
    </div>
</div>
