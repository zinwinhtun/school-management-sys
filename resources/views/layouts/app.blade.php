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

<body class="bg-light min-vh-100 d-flex">
    <!-- Sidebar -->
    <aside class="bg-indigo text-white d-none d-md-flex flex-column justify-between" style="width: 260px;">
        <div>
            <div class="p-4 text-center fw-bold fs-5 border-bottom border-indigo-400">GLORY</div>
            <nav class="mt-4">
                <a href="{{route('dashboard')}}" class="d-block py-2 px-4 text-white text-decoration-none hover-bg-indigo">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
                <a href="{{route('users.index')}}" class="d-block py-2 px-4 text-white text-decoration-none hover-bg-indigo">
                    <i class="bi bi-people me-2"></i>Users
                </a>
                <a href="#" class="d-block py-2 px-4 text-white text-decoration-none hover-bg-indigo">
                    <i class="bi bi-person-vcard me-2"></i>Students
                </a>
                <a href="#" class="d-block py-2 px-4 text-white text-decoration-none hover-bg-indigo">
                    <i class="bi bi-cash-coin me-2"></i>Fees
                </a>
                <a href="#" class="d-block py-2 px-4 text-white text-decoration-none hover-bg-indigo">
                    <i class="bi bi-journal-text me-2"></i>Books
                </a>
                <a href="#" class="d-block py-2 px-4 text-white text-decoration-none hover-bg-indigo">
                    <i class="bi bi-graph-down me-2"></i>Expenses
                </a>
                <a href="#" class="d-block py-2 px-4 text-white text-decoration-none hover-bg-indigo">
                    <i class="bi bi-bar-chart me-2"></i>Reports
                </a>
            </nav>
        </div>
        <div class="p-4 border-top border-indigo-400">
            <p class="mb-0 text-light">&copy; {{ date('Y') }} SchoolSystem</p>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-grow-1 d-flex flex-column">
        <!-- Top Navbar -->
        <nav class="bg-white shadow-sm p-3 d-flex justify-content-between align-items-center">
            <button class="btn btn-outline-indigo d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <i class="bi bi-list"></i>
            </button>

            <!-- Responsive Title -->
            <h1 class="h5 fw-semibold text-dark mb-0 d-none d-sm-block">School Management System</h1>
            <h1 class="h6 fw-semibold text-dark mb-0 d-sm-none">SMS</h1>

            <!-- Settings Dropdown -->
            <div class="dropdown">
                <button class="btn btn-outline-indigo dropdown-toggle d-flex align-items-center"
                    type="button" data-bs-toggle="dropdown" data-bs-auto-close="true"
                    aria-expanded="false">
                    <i class="bi bi-gear-fill"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="dropdown-header text-muted small">{{ Auth::user()->email }}</li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.show') }}">
                            <i class="bi bi-person me-2"></i>Profile
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right me-2"></i>Log Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="p-4 flex-grow-1">
            @yield('content')
        </main>
    </div>

    <!-- Mobile Sidebar -->
    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="mobileSidebar">
        <div class="offcanvas-header bg-indigo text-white">
            <h5 class="offcanvas-title">GLORY</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body bg-indigo text-white p-0">
            <nav class="nav flex-column">
                <a href="{{route('dashboard')}}" class="nav-link text-white py-3 px-4 border-bottom border-indigo-400">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
                <a href="{{route('users.index')}}" class="nav-link text-white py-3 px-4 border-bottom border-indigo-400">
                    <i class="bi bi-people me-2"></i>Users
                </a>
                <a href="#" class="nav-link text-white py-3 px-4 border-bottom border-indigo-400">
                    <i class="bi bi-person-vcard me-2"></i>Students
                </a>
                <a href="#" class="nav-link text-white py-3 px-4 border-bottom border-indigo-400">
                    <i class="bi bi-cash-coin me-2"></i>Fees
                </a>
                <a href="#" class="nav-link text-white py-3 px-4 border-bottom border-indigo-400">
                    <i class="bi bi-journal-text me-2"></i>Books
                </a>
                <a href="#" class="nav-link text-white py-3 px-4 border-bottom border-indigo-400">
                    <i class="bi bi-graph-down me-2"></i>Expenses
                </a>
                <a href="#" class="nav-link text-white py-3 px-4 border-bottom border-indigo-400">
                    <i class="bi bi-bar-chart me-2"></i>Reports
                </a>
                <a href="{{route('profile.show')}}" class="nav-link text-white py-3 px-4 border-bottom border-indigo-400">
                    <i class="bi bi-gear me-2"></i>Setting
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link text-white py-3 px-4 text-start w-100 bg-transparent border-0">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </button>
                </form>
            </nav>
        </div>
    </div>

    <script>
        // Custom hover effect for sidebar links
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarLinks = document.querySelectorAll('.hover-bg-indigo');
            sidebarLinks.forEach(link => {
                link.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = 'rgba(255,255,255,0.1)';
                });
                link.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });
        });
    </script>

</body>

</html>