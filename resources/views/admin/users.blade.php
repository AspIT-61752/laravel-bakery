<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        User Management
                    </h2>
                    <div class="mt-4">
                        <ul>
                            @foreach ($users as $user)
                                <li
                                    class="flex justify-between items-center mb-2 py-2 {{ $loop->last ? '' : 'border-b border-gray-200' }}">
                                    <div class="grid grid-cols-6 gap-1 items-center w-auto">
                                        <p class="m-auto col-span-1 text-sm">id: {{ $user->id }}</p>
                                        <input type="text" name="name" form="update-user-{{ $user->id }}"
                                            value="{{ $user->name }}" class="border p-2 rounded col-span-2 w-full" />
                                        <input type="email" name="email" form="update-user-{{ $user->id }}"
                                            value="{{ $user->email }}" class="border p-2 rounded col-span-3 w-full" />
                                    </div>
                                    <div class="flex items-center">

                                        {{-- Make Admin / Remove Admin --}}

                                        @if (isset($user->is_admin) && !$user->is_admin)
                                            <form class="pr-2"
                                                action="{{ route('admin.make-admin', ['userID' => $user->id]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Make
                                                    Admin</button>
                                            </form>
                                        @else
                                            <form class="pr-2"
                                                action="{{ route('admin.remove-admin', ['userID' => $user->id]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Remove
                                                    Admin</button>
                                            </form>
                                        @endif

                                        {{-- Update User Info --}}

                                        <form id="update-user-{{ $user->id }}"
                                            action="{{ route('admin.change-user-info', ['userID' => $user->id]) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Update
                                                User Info</button>
                                        </form>

                                        {{-- Delete User --}}

                                        <form class="pl-2"
                                            action="{{ route('admin.remove-user', ['userID' => $user->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
