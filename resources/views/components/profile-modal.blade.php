<div
    x-data="{ open: false }"
    x-on:open-profile-modal.window="open = true"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
>
    <div @click.outside="open = false"
         class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">

        <h2 class="text-lg font-semibold text-gray-700 mb-4">Edit Profile</h2>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                    value="{{ old('name', Auth::user()->name) }}" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                    value="{{ old('email', Auth::user()->email) }}" required />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button"
                    @click="open = false"
                    class="px-4 py-2 text-gray-700 border rounded-md hover:bg-gray-100">
                    Cancel
                </button>

                <x-primary-button>
                    {{ __('Save Changes') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
