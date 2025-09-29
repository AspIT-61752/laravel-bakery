<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between mb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            Products Management
                        </h2>
                        <div>
                            <a href="{{ route('admin.create-product') }}" class="text-blue-500 hover:text-blue-700">
                                <p>Create New Product</p>
                            </a>
                        </div>
                    </div>
                    {{-- {{ dd($products, $selectedItem) }} --}}
                    <x-edit-data-comp :data=$products :dataType="'product'" :selectedItem="$selectedItem" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
