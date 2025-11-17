<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GLORY | Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>
<body class="bg-light min-vh-100 d-flex align-items-center justify-content-center">

    <div class="w-100" style="max-width: 400px;">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body p-5">
                <!-- Logo -->
                <div class="text-center mb-4">
                    <i class="bi bi-safe-fill text-primary" style="font-size: 3rem;"></i>
                </div>

                <h2 class="text-center h3 fw-bold text-dark mb-4">GLORY</h2>

                <!-- Session Status -->
                @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show text-center mb-4" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input id="name" name="name" type="name" value="{{ old('name') }}"
                            required autofocus
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Enter your name">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input id="password" name="password" type="password" required
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter your password">
                            <button type="button" id="togglePassword" class="btn btn-outline-secondary">
                                <i id="eyeIcon" class="bi bi-eye"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Log in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Toggle Password Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle eye icon
                if (type === 'password') {
                    eyeIcon.classList.remove('bi-eye-slash');
                    eyeIcon.classList.add('bi-eye');
                } else {
                    eyeIcon.classList.remove('bi-eye');
                    eyeIcon.classList.add('bi-eye-slash');
                }
            });
        });
    </script>

</body>
</html>