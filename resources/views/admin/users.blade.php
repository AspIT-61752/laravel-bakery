<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        User Management
                    </h2>
                    <x-edit-data-comp :data="$users" data-type="user" :selectedItem="$selectedItem" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
