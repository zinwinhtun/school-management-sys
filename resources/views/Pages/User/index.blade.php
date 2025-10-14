@extends('layouts.app')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <!-- Left: Title -->
    <div>
        <h1 class="text-2xl font-semibold">Users Management</h1>
    </div>

    <!-- Right: Button -->
    <div>
        <x-button color="indigo" size="sm">Create new user</x-button>
    </div>
</div>
<div class="card mt-3 shadow rounded">
    <div class="card-body">
    <x-table>
    <x-slot name="thead">
        <tr>
            <th class="px-4 py-2 text-left w-1/4">Name</th>
            <th class="px-4 py-2 text-left w-1/4">Email</th>
            <th class="px-4 py-2 text-left w-1/4">Role</th>
            <th class="px-4 py-2 text-left w-1/4">Actions</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($users as $user)
            <tr>
                <td class="px-4 py-2">{{ $user->name }}</td>
                <td class="px-4 py-2">{{ $user->email }}</td>
                <td class="px-4 py-2">{{ $user->role }}</td>
                <td class="px-4 py-2 flex gap-2">
                    <x-button color="blue" size="xs">Edit</x-button>
                    <x-button color="red" size="xs">Delete</x-button>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-table>

<!-- //paginate -->
{{ $users->links() }}
    </div>
</div>



@endsection