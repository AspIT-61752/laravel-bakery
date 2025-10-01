@props(['data', 'dataType', 'selectedItem' => null, 'productTypes' => null, 'ingredients' => null])
@php

    use App\Models\ProductType;

    $editingItem = $selectedItem ?? null;
    $productTypes = ProductType::all() ?? null;
    // $PT = $productTypes ?? null;
    // $ingredients = $ingredients ?? null;
@endphp

<div>
    <!-- Modal toggle -->
    <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        type="button">
        Edit {{ ucfirst($dataType) }}
    </button>

    {{-- I have to press the button to open the editing page --}}
    @if ($editingItem)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var btn = document.querySelector('[data-modal-toggle="crud-modal"]');
                if (btn) {
                    // wait for 450 ms
                    setTimeout(function() {
                        btn.click();
                    }, 350);
                }
            })
        </script>
    @endif

    <!-- Main modal -->
    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    {{-- The title --}}
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Edit {{ ucfirst($dataType) }}
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                @if ($editingItem)
                    <form class="p-4 md:p-5" method="POST"
                        action="{{ $dataType === 'user' ? route('admin.change-user-info', ['userID' => $editingItem->id]) : route('admin.edit-product-info', ['prodID' => $editingItem->id]) }}"
                        @if ($dataType === 'user') enctype="multipart/form-data"
                            @csrf @endif
                        @if ($dataType === 'product') enctype="multipart/form-data" @endif>
                        @csrf
                        @method('PUT')
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            @foreach ($columnsToShow as $column)
                                @if ($column === 'id')
                                    @continue
                                @endif
                                @if ($dataType === 'product' && $column === 'image')
                                    <div class="col-span-2">
                                        <label for="image"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current
                                            image</label>
                                        <img src="{{ asset($editingItem->image) }}" alt="{{ $editingItem->name }}"
                                            class="h-16 w-16 object-cover mb-2">
                                        <input type="file" name="image" id="image"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    </div>
                                    @continue
                                @endif
                                @if ($dataType === 'product' && $column === 'product_type_id')
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="product_type_id"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type</label>
                                        <select name="product_type_id" id="product_type_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            required>
                                            <option value="">Select a type</option>
                                            @foreach ($productTypes as $type)
                                                <option value="{{ $type->id }}"
                                                    @if ($editingItem->product_type_id == $type->id) selected @endif>
                                                    {{ $type->type_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @continue
                                @endif
                                <div class="col-span-2">
                                    <label for="{{ $column }}"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ ucfirst($column) }}</label>
                                    <input type="text" name="{{ $column }}" id="{{ $column }}"
                                        value="{{ $editingItem->$column ?? '' }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Enter {{ $column }}" required>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex items-center justify-between space-x-2">
                            <button type="submit"
                                class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <x-bx-edit class="w-6" />
                                Save changes
                            </button>

                            <button type="button" data-modal-toggle="crud-modal"
                                class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                <x-mdi-trash-can-outline class="w-6" />
                                Discard changes
                            </button>
                        </div>
                    </form>
                @else
                    <div class="p-4 text-red-500">No {{ $dataType }} selected for editing.</div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- The table --}}
<div class="mt-4 grid md:grid-cols-2 sm:grid-cols-2 gap-4">
    <div class="col-span-2 md:col-span-2 sm:col-span-1">
        {{-- The form --}}
        <table action="" class="overflow-scroll w-full">
            <thead>
                <tr>
                    @foreach ($columnsToShow as $column)
                        @if ($column === 'product_type_id' && $dataType === 'product')
                            <th class="border px-2 py-2">Type</th>
                        @else
                            <th class="border px-2 py-2">{{ ucfirst($column) }}</th>
                        @endif
                    @endforeach
                    <th class="border px-2 py-2" scope="col">Actions</th>
                </tr>
            </thead>
            {{-- {{ dd($data) }} --}}
            @foreach ($data as $item)
                <tr>
                    @foreach ($columnsToShow as $column)
                        @if ($column === 'id')
                            <th>{{ $item->id }}</th>
                        @elseif ($column === 'image')
                            <td class="border px-4 py-2">
                                <img src="{{ asset($item->image) }}" alt="{{ $item->name }}"
                                    class="h-16 w-16 object-cover">
                            </td>
                        @elseif ($column === 'product_type_id' && $dataType === 'product')
                            <td class="border px-4 py-2">
                                @php
                                    $type = $productTypes->firstWhere('id', $item->product_type_id);
                                @endphp
                                <p>{{ $type ? $type->type_name : 'N/A' }}</p>
                            </td>
                        @else
                            <td class="border px-4 py-2">
                                <p>{{ $item->$column }}</p>
                            </td>
                        @endif
                    @endforeach
                    {{-- Buttons --}}
                    <td class="border px-4 py-2">
                        {{-- Edit Button --}}
                        {{-- If the user presses this button it'll set the itemID to the ID of this and get the data in the edit info tab --}}


                        @if ($dataType === 'user')
                            <form method="GET" action="{{ route('admin.edit-user') }}" class="inline">
                                <input type="hidden" name="edit_id" value="{{ $item->id }}">
                                @csrf
                                <button type="submit" name="edit_id" value="{{ $item->id }}"
                                    class="p-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    <x-bx-edit class="w-5 h-5" />
                                </button>
                            </form>
                            {{-- Delete Button --}}
                            <form action="{{ route('admin.remove-user', ['userID' => $item->id]) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 bg-red-500 text-white rounded hover:bg-red-600">
                                    <x-bx-trash class="w-5 h-5" />
                                </button>
                            </form>
                        @endif
                        @if ($dataType === 'product')
                            <form method="GET" action="{{ route('admin.edit-product') }}" class="inline">
                                <input type="hidden" name="edit_id" value="{{ $item->id }}">
                                @csrf
                                <button type="submit" name="edit_id" value="{{ $item->id }}"
                                    class="p-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    <x-bx-edit class="w-5 h-5" />
                                </button>
                            </form>
                            {{-- Delete Button --}}
                            <form action="{{ route('admin.remove-product', ['prodID' => $item->id]) }}"
                                method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 bg-red-500 text-white rounded hover:bg-red-600">
                                    <x-bx-trash class="w-5 h-5" />
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
