@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 space-y-4 md:space-y-0">
        <h2 class="text-2xl font-bold text-gray-800">Users</h2>
        <div class="flex items-center space-x-4">
            <input type="text" placeholder="Search..." x-model="search" 
                class="border border-gray-300 rounded-md px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            <button @click="openCreate = true" 
                class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 transition">
                + Add User
            </button>
        </div>
    </div>

    <!-- Total Users -->
    <div class="text-gray-600 mb-2">Total Users: {{ $users->total() }}</div>

    <!-- Users Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Email</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Role</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2">
                        @if($user->role === 'admin')
                        <span class="px-2 py-1 rounded-full bg-blue-200 text-blue-800 text-xs font-semibold">Admin</span>
                        @else
                        <span class="px-2 py-1 rounded-full bg-green-200 text-green-800 text-xs font-semibold">Staff</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 flex space-x-2">
                        <button @click="openEdit = true; editUser = {{ json_encode($user) }}" 
                            class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition text-sm">Edit</button>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition text-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="p-4">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modals -->
    <div x-data="{ openCreate: false, openEdit: false, editUser: null }">
        <!-- Overlay -->
        <div x-show="openCreate || openEdit" x-cloak
            class="fixed inset-0 bg-black bg-opacity-40 z-40 transition-opacity"></div>

        <!-- Create Modal -->
        <div x-show="openCreate" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div @click.outside="openCreate = false" class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 transform transition-all">
                <h2 class="text-xl font-bold mb-4">Add New User</h2>
                <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
                    @csrf
                    <input type="text" name="name" placeholder="Name" class="input-field">
                    <input type="email" name="email" placeholder="Email" class="input-field">
                    <select name="role" class="input-field">
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                    </select>
                    <input type="password" name="password" placeholder="Password" class="input-field">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" class="input-field">
                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="openCreate=false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div x-show="openEdit" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div @click.outside="openEdit=false" class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 transform transition-all">
                <h2 class="text-xl font-bold mb-4">Edit User</h2>
                <form :action="'/users/' + editUser?.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" :value="editUser?.name" class="input-field">
                    <input type="email" name="email" :value="editUser?.email" class="input-field">
                    <select name="role" class="input-field">
                        <option value="admin" :selected="editUser?.role==='admin'">Admin</option>
                        <option value="staff" :selected="editUser?.role==='staff'">Staff</option>
                    </select>
                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="openEdit=false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- Tailwind helper class for input fields -->
<style>
.input-field {
    @apply mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2;
}
</style>

@endsection
