@php
    use App\Models\Product;
    $posts = Product::all();

    // Get 4 random posts, but makes sure it's never the same prod
    $randomPosts = [];
    $postsCount = $posts->count();
    $usedNumbers = [];
    $numToSelect = min(4, $postsCount);

    while (count($randomPosts) < $numToSelect) {
        $randomIndex = rand(0, $postsCount - 1);
        if (!in_array($randomIndex, $usedNumbers)) {
            $usedNumbers[] = $randomIndex;
            $randomPosts[] = $posts[$randomIndex];
        }
    }

@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Welcome to the Recipes Showcase') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- {{ dd($posts) }} --}}
                <div class="p-6 text-gray-900">
                    <p class="mb-4 font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Some of our delicious recipes') }}
                    </p>

                    {{-- Img carousel --}}
                    <div id="default-carousel" class="relative w-full" data-carousel="slide">
                        <!-- Carousel wrapper -->
                        <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                            <!-- Items -->
                            @foreach ($randomPosts as $post)
                                <div class="{{ $loop->index === 0 ? 'hidden' : '' }} duration-700 ease-in-out"
                                    data-carousel-item>
                                    {{-- <a href="products/{{ $post->slug }}"><img src="{{ $post->image }}"
                                            class="absolute block w-full object-cover object-top -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                            alt="{{ $post->name }}"></a> --}}
                                    <a href="products/{{ $post->slug }}">
                                        <div class="relative w-full h-56 md:h-96 overflow-hidden">
                                            <!-- Blurry background -->
                                            <img src="{{ $post->image }}"
                                                class="absolute inset-0 w-full h-full object-cover filter blur-lg scale-110"
                                                alt="">
                                            <!-- Main image -->
                                            <img src="{{ $post->image }}"
                                                class="relative w-full h-full object-contain object-center z-10"
                                                alt="{{ $post->name }}">
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <!-- Slider indicators -->
                        {{-- <div
                            class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                            @foreach ($randomPosts as $post)
                                <button type="button" class="w-3 h-3 rounded-full"
                                    aria-current="{{ $loop->index === 0 ? 'true' : 'false' }}"
                                    aria-label="Slide {{ $loop->index + 1 }}"
                                    data-carousel-slide-to="{{ $loop->index }}">
                                </button>
                            @endforeach
                        </div> --}}
                        <!-- Slider controls -->
                        <button type="button"
                            class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                            data-carousel-prev>
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 1 1 5l4 4" />
                                </svg>
                                <span class="sr-only">Previous</span>
                            </span>
                        </button>
                        <button type="button"
                            class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                            data-carousel-next>
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <span class="sr-only">Next</span>
                            </span>
                        </button>
                    </div>

                </div>

                <x-product-showcase :posts="$posts" />
            </div>
        </div>
    </div>
</x-app-layout>
