@props(['data', 'dataType', 'selectedItem' => null, 'productTypes' => null, 'ingredients' => null])
@php

    use App\Models\ProductType;

    $editingItem = $selectedItem ?? null;
    $productTypes = ProductType::all() ?? null;
    // $PT = $productTypes ?? null;
    // $ingredients = $ingredients ?? null;
@endphp

<div class="mt-4 grid md:grid-cols-3 sm:grid-cols-1 gap-4">
    <div class="col-span-2 md:col-span-2 sm:col-span-1">
        {{-- The form --}}
        <table action="" class="col-span-2 sm:col-span-1 overflow-scroll">
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
                            <form action="{{ route('admin.remove-product', ['prodID' => $item->id]) }}" method="POST"
                                class="inline">
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
    {{-- Edit User Info --}}

    {{-- When the user presses the edit button, all of the info in here should update with the row of data --}}
    <div class="col-span-1">
        <p>Edit {{ ucfirst($dataType) }} Info</p>
        @if ($dataType === 'user')
            {{-- All cols for the selected dataType of User --}}
            @if (!$editingItem)
                <p class="text-red-500">No user selected</p>
            @else
                @foreach ($columnsToShow as $column)
                    <p class="text-sm mb-1">{{ ucfirst($column) }}</p>
                    <input type="text" name="{{ $column }}" form="update-user-{{ $editingItem->id ?? '' }}"
                        value="{{ $editingItem->$column ?? '' }}" class="border p-2 rounded col-span-2 w-full" />
                @endforeach
                <input type="hidden" id="selectedItemID" name="selectedItemID" value="">
                <form id="update-user-{{ $editingItem->id }}"
                    action="{{ route('admin.change-user-info', ['userID' => $editingItem->id]) }}" method="POST"
                    class="inline mt-2">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="p-1 bg-green-500 text-white rounded hover:bg-green-600">
                        <x-bx-edit class="w-10" /></button>
            @endif
        @endif
        @if ($dataType === 'product')
            {{-- All cols for dataType Product --}}
            @if (!$editingItem)
                <p class="text-red-500">No product selected</p>
            @else
                @foreach ($columnsToShow as $column)
                    @if ($column === 'image')
                        <p class="text-sm mb-1">Current Image</p>
                        <img src="{{ asset($editingItem->image) }}" alt="{{ $editingItem->name }}"
                            class="h-32 w-32 object-cover mb-2">
                        <p class="text-sm mb-1">Change Image</p>
                        <input type="file" name="{{ $column }}"
                            form="update-prod-{{ $editingItem->id ?? '' }}"
                            class="border p-2 rounded col-span-2 w-full" />
                        @continue
                    @endif
                    {{-- A dropdown I made for Create Products --}}
                    @if ($column === 'product_type_id')
                        <p class="text-sm mb-1">Type</p>
                        <select name="product_type_id" id="product_type_id"
                            class="border border-gray-600 rounded p-2 w-full"
                            form="update-prod-{{ $editingItem->id ?? '' }}" required>
                            <option value="">Select a type</option>
                            @foreach ($productTypes as $type)
                                <option value="{{ $type->id }}" @if (isset($editingItem) && $editingItem->product_type_id == $type->id) selected @endif>
                                    {{ $type->type_name }}
                                </option>
                            @endforeach
                        </select>
                        @continue
                    @endif
                    <p class="text-sm mb-1">{{ ucfirst($column) }}</p>
                    <input type="text" name="{{ $column }}" form="update-prod-{{ $editingItem->id ?? '' }}"
                        value="{{ $editingItem->$column ?? '' }}" class="border p-2 rounded col-span-2 w-full" />
                @endforeach
                <input type="hidden" id="selectedItemID" name="selectedItemID" value="">
                <form id="update-prod-{{ $editingItem->id }}"
                    action="{{ route('admin.edit-product-info', ['prodID' => $editingItem->id]) }}" method="POST"
                    enctype="multipart/form-data" class="inline mt-2">
                    @csrf
                    @method('PUT')
                    <button type="submit"
                        class="p-1 bg-green-500 text-white rounded hover:bg-green-600 flex text-center">
                        <p>
                            save
                        </p>
                        <x-bx-edit class="w-10" />
                    </button>
            @endif
        @endif
    </div>
</div>
