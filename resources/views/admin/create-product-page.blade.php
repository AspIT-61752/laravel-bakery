@php
    // dd($productTypes);
@endphp
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Products Creator
                    </h2>
                    {{-- Form for the entire thing, could be moved to a component later --}}
                    <div class="">
                        <form action="{{ route('admin.add-product') }}" method="POST" enctype="multipart/form-data"
                            class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @csrf
                            <div class="flex flex-col gap-2">
                                <label for="name" class="">Product name</label>
                                <input type="text" name="name" id="name"
                                    class="border border-gray-600 rounded p-2 w-full" required>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="image" class="">Product image</label>
                                <input type="file" name="image" id="image"
                                    class="border border-gray-600 rounded p-2 w-full" required>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="product_type_id" class="">Product type</label>
                                <select name="product_type_id" id="product_type_id"
                                    class="border border-gray-600 rounded p-2 w-full" required>
                                    <option value="">Select a type</option>
                                    @foreach ($productTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="description" class="">Product description</label>
                                <input name="description" id="description"
                                    class="border border-gray-600 rounded p-2 w-full" required></input>
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="recipe" class="">Product recipe</label>
                                <textarea name="recipe" id="recipe" class="border border-gray-600 rounded p-2 w-full" rows="5" required></textarea>
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="ingredients[]" class="">Ingredients</label>
                                <select name="ingredients[]" id="ingredients"
                                    class="border border-gray-600 rounded p-2 w-full" size="6" multiple required>
                                    @foreach ($ingredients as $ingredient)
                                        <option value="{{ $ingredient->id }}">{{ $ingredient->ingredient_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Submit button --}}
                            <div class="flex col-span-2 justify-end">
                                <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create
                                    Product</button>
                            </div>
                        </form>
                    </div>
                    {{-- <x-product-creator /> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
