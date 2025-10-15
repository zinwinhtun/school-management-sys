<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GLORY | Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md p-8 bg-white shadow-lg rounded-lg">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-indigo-600" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6v6l4 2m6 8H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2h4a2 2 0 012 2v12a2 2 0 01-2 2z" />
            </svg>
        </div>

        <h2 class="text-center text-2xl font-bold text-gray-800 mb-6">GLORY</h2>

        <!-- Session Status -->
        @if(session('status'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded text-center">
                {{ session('status') }}
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}"
                    required autofocus
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="relative">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                
                <!-- Toggle Button -->
                <button type="button" id="togglePassword"
                    class="absolute right-3 top-9 text-gray-500 hover:text-indigo-600 focus:outline-none">
                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.302 4.5 12 4.5c4.698 0 8.577 3.01 9.964 7.178.07.204.07.44 0 .644C20.577 16.49 16.698 19.5 12 19.5c-4.698 0-8.577-3.01-9.964-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg id="eyeClose" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="w-5 h-5 hidden">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.98 8.223A10.477 10.477 0 001.934 12c1.286 4.052 5.056 7 10.066 7a10.48 10.48 0 005.006-1.223M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 2.25l19.5 19.5" />
                    </svg>
                </button>

                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mt-4">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <label for="remember_me" class="ml-2 text-sm text-gray-600">Remember me</label>
            </div>

            <!-- Submit -->
            <div class="mt-6">
                <button type="submit"
                    class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    Log in
                </button>
            </div>
        </form>
    </div>

    <!-- Toggle Password Script -->
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClose = document.getElementById('eyeClose');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeOpen.classList.toggle('hidden');
            eyeClose.classList.toggle('hidden');
        });
    </script>

</body>
</html>
