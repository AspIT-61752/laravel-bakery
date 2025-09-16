<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Admin Dashboard
                    </h2>
                    <div>
                        {{-- <ul>
                            <li><a href="admin/users">Manage Users</a></li>
                            <li><a href="admin/products">Manage Products</a></li>
                            <li><a href="admin/settings">Settings</a></li>
                        </ul> --}}
                        <div class="grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 gap-4">
                            {{-- Using the RedirectCard component for navigation --}}
                            <x-redirect-card :title="'Manage Users'" :content="'Go to user management page'" :url="route('admin.users')" />

                            <x-redirect-card :title="'Manage Products'" :content="'Go to product management page'" :url="route('admin.products')" />

                            <x-redirect-card :title="'Settings'" :content="'Go to settings page'" :url="route('admin.settings')" />
                        </div>
                    </div>
                </div>
            </div>
</x-app-layout>
