<!-- Change Password Modal -->
<div
    x-data="{ open: {{ $errors->updatePassword->isNotEmpty() ? 'true' : 'false' }} }"
    x-on:open-password-modal.window="open = true"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
>
    <div @click.outside="open = false"
        class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 transition-all">

        <h2 class="text-lg font-semibold text-gray-700 mb-4">Change Password</h2>

        <!-- Validation Errors or Success -->
        @if (session('status') === 'password-updated')
            <div x-data="{ show: true }" x-show="show"
                x-init="setTimeout(() => show = false, 3000)"
                class="mb-4 p-2 bg-green-100 text-green-700 rounded">
                Password changed successfully!
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <!-- Current Password -->
            <div class="mb-4 relative" x-data="{ show: false }">
                <x-input-label for="current_password" :value="__('Current Password')" />
                <input :type="show ? 'text' : 'password'" id="current_password" name="current_password"
                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required autocomplete="current-password" />
                <button type="button" @click="show = !show"
                    class="absolute right-3 top-9 text-gray-500 hover:text-indigo-600 focus:outline-none">
                    <!-- eye icons -->
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.302 4.5 12 4.5c4.698 0 8.577 3.01 9.964 7.178.07.204.07.44 0 .644C20.577 16.49 16.698 19.5 12 19.5c-4.698 0-8.577-3.01-9.964-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.98 8.223A10.477 10.477 0 001.934 12c1.286 4.052 5.056 7 10.066 7a10.48 10.48 0 005.006-1.223M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 2.25l19.5 19.5" />
                    </svg>
                </button>
                <x-input-error class="mt-2" :messages="$errors->updatePassword->get('current_password')" />
            </div>

            <!-- New Password -->
            <div class="mb-4 relative" x-data="{ show: false }">
                <x-input-label for="password" :value="__('New Password')" />
                <input :type="show ? 'text' : 'password'" id="password" name="password"
                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required autocomplete="new-password" />
                <button type="button" @click="show = !show"
                    class="absolute right-3 top-9 text-gray-500 hover:text-indigo-600 focus:outline-none">
                    <!-- eye icons -->
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.302 4.5 12 4.5c4.698 0 8.577 3.01 9.964 7.178.07.204.07.44 0 .644C20.577 16.49 16.698 19.5 12 19.5c-4.698 0-8.577-3.01-9.964-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.98 8.223A10.477 10.477 0 001.934 12c1.286 4.052 5.056 7 10.066 7a10.48 10.48 0 005.006-1.223M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 2.25l19.5 19.5" />
                    </svg>
                </button>
                <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password')" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-4 relative" x-data="{ show: false }">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <input :type="show ? 'text' : 'password'" id="password_confirmation" name="password_confirmation"
                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required autocomplete="new-password" />
                <button type="button" @click="show = !show"
                    class="absolute right-3 top-9 text-gray-500 hover:text-indigo-600 focus:outline-none">
                    <!-- eye icons -->
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.302 4.5 12 4.5c4.698 0 8.577 3.01 9.964 7.178.07.204.07.44 0 .644C20.577 16.49 16.698 19.5 12 19.5c-4.698 0-8.577-3.01-9.964-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.98 8.223A10.477 10.477 0 001.934 12c1.286 4.052 5.056 7 10.066 7a10.48 10.48 0 005.006-1.223M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 2.25l19.5 19.5" />
                    </svg>
                </button>
                <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password_confirmation')" />
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button"
                    @click="open = false"
                    class="px-4 py-2 text-gray-700 border rounded-md hover:bg-gray-100">
                    Cancel
                </button>

                <x-primary-button>
                    {{ __('Update Password') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
