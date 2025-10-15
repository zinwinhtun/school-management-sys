@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 space-y-6">

    <!-- Profile Card -->
    <div class="bg-white rounded-lg shadow p-6 flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6">
        <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center text-2xl font-bold text-gray-500">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <div class="flex-1">
            <h2 class="text-xl font-semibold text-gray-800">{{ Auth::user()->name }}</h2>
            <p class="text-gray-600">{{ Auth::user()->email }}</p>
            <p class="text-gray-600 capitalize">{{ Auth::user()->role }}</p>
        </div>
    </div>

    <!-- Tabs + Forms -->
    <div class="bg-white rounded-lg shadow p-6"
        x-data="{ activeTab: '{{ $errors->any() ? (count($errors->updatePassword) ? 'password' : 'profile') : 'profile' }}' }">

        <!-- Tabs -->
        <div class="flex border-b border-gray-200 mb-6">
            <button @click="activeTab = 'profile'" 
                :class="activeTab === 'profile' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="py-2 px-4 border-b-2 font-medium text-sm focus:outline-none">
                Update Profile
            </button>

            <button @click="activeTab = 'password'"
                :class="activeTab === 'password' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="py-2 px-4 border-b-2 font-medium text-sm focus:outline-none">
                Update Password
            </button>
        </div>

        <!-- Profile Form -->
        <div x-show="activeTab === 'profile'" x-cloak>
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('patch')

                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Role</label>
                    <input type="text" value="{{ Auth::user()->role }}" disabled
                        class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update Profile</button>
                </div>
            </form>
        </div>

        <!-- Password Form -->
        <div x-show="activeTab === 'password'" x-cloak>
            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="relative" x-data="{ show: false }">
                    <label class="block text-sm font-medium text-gray-700">Current Password</label>
                    <input :type="show ? 'text' : 'password'" name="current_password" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <button type="button" @click="show = !show" class="absolute right-3 top-9 text-gray-500 hover:text-indigo-600">
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.05 10.05 0 011.658-3.084M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                        </svg>
                    </button>
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative" x-data="{ show: false }">
                    <label class="block text-sm font-medium text-gray-700">New Password</label>
                    <input :type="show ? 'text' : 'password'" name="password" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative" x-data="{ show: false }">
                    <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input :type="show ? 'text' : 'password'" name="password_confirmation" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update Password</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
