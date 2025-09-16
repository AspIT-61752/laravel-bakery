<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Products Management
                    </h2>
                    <div>
                        <ul>
                            @foreach ($products as $product)
                                <li>
                                    {{ $product->name }}
                                    <a href="{{ route('admin.edit-product', $product->id) }}">Edit</a>
                                    <form action="{{ route('admin.delete-product', $product->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Delete</button>
                                    </form>
                                </li>
                            @endforeach
                            {{-- Button to create a new product --}}
                            <li class="mt-4">
                                <a href="{{ route('admin.create-product') }}"
                                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Add New
                                    Product</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
