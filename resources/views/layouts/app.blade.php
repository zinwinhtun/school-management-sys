<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex">
    <!-- Sidebar -->
    <aside class="bg-indigo-700 text-white w-64 min-h-screen hidden md:flex flex-col justify-between">
        <div>
            <div class="p-4 text-center font-bold text-lg border-b border-indigo-500">GLORY</div>
            <nav class="mt-4 space-y-2">
                <a href="{{route('dashboard')}}" class="block py-2.5 px-4 hover:bg-indigo-600">Dashboard</a>
                <a href="{{route('users.index')}}" class="block py-2.5 px-4 hover:bg-indigo-600">Users</a>
                <a href="#" class="block py-2.5 px-4 hover:bg-indigo-600">Students</a>
                <a href="#" class="block py-2.5 px-4 hover:bg-indigo-600">Fees</a>
                <a href="#" class="block py-2.5 px-4 hover:bg-indigo-600">Books</a>
                <a href="#" class="block py-2.5 px-4 hover:bg-indigo-600">Expenses</a>
                <a href="#" class="block py-2.5 px-4 hover:bg-indigo-600">Reports</a>
            </nav>
        </div>
        <div class="p-4 border-t border-indigo-600 text-sm text-gray-200">
            <p>&copy; {{ date('Y') }} SchoolSystem</p>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Top Navbar -->
        <nav class="bg-white shadow-md p-4 flex justify-between items-center">
            <button id="sidebarToggle" class="md:hidden text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5M3.75 12h16.5m-16.5 6.75h16.5" />
                </svg>
            </button>
            <h1 class="text-lg font-semibold text-gray-700">School Management System</h1>
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 relative" x-data="{ open: false }">
                <!-- Trigger Button -->
                <button @click="open = !open"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                    <div>{{ Auth::user()->name }}</div>
                    <div class="ms-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>

                <!-- Dropdown Menu (from bottom of button) -->
                <div x-show="open" @click.outside="open = false"
                    class="absolute right-0 top-full mt-1 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-50"
                    style="display: none;">

                    <!-- User Email -->
                    <div class="block px-4 py-2 text-sm text-gray-700">
                        {{ Auth::user()->email }}
                    </div>

                    <!-- Profile Setting  -->
                    <a href="{{ route('profile.show') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Profile
                    </a>
                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>


        </nav>

        <main class="p-5">
            @yield('content')
        </main>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="mobileSidebar" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40">
        <aside class="bg-indigo-700 text-white w-64 h-full p-4">
            <button id="closeSidebar" class="mb-4 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <nav class="space-y-2">
                <a href="{{route('dashboard')}}" class="block py-2 px-3 hover:bg-indigo-600 rounded">Dashboard</a>
                <a href="{{route('users.index')}}" class="block py-2.5 px-4 hover:bg-indigo-600">Users</a>
                <a href="#" class="block py-2 px-3 hover:bg-indigo-600 rounded">Students</a>
                <a href="#" class="block py-2 px-3 hover:bg-indigo-600 rounded">Fees</a>
                <a href="#" class="block py-2 px-3 hover:bg-indigo-600 rounded">Books</a>
                <a href="#" class="block py-2 px-3 hover:bg-indigo-600 rounded">Expenses</a>
                <a href="#" class="block py-2 px-3 hover:bg-indigo-600 rounded">Reports</a>
                <a href="{{route('profile.show')}}" class="block py-2 px-3 hover:bg-indigo-600 rounded">Setting</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class=" py-2 px-3 hover:bg-indigo-600 rounded">Logout</button>
                </form>
            </nav>
        </aside>
    </div>


    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const closeSidebar = document.getElementById('closeSidebar');

        sidebarToggle.addEventListener('click', () => {
            mobileSidebar.classList.remove('hidden');
        });

        closeSidebar.addEventListener('click', () => {
            mobileSidebar.classList.add('hidden');
        });

        mobileSidebar.addEventListener('click', (e) => {
            if (e.target === mobileSidebar) mobileSidebar.classList.add('hidden');
        });
    </script>
</body>

</html>