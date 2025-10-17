@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <!-- Profile Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="bg-dark bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <span class="text-primary fw-bold fs-3">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            </div>
                        </div>
                        <div class="col">
                            <h2 class="h4 fw-bold text-dark mb-1 text-uppercase">{{ Auth::user()->name }}</h2>
                            <p class="text-muted mb-1">
                                <i class="bi bi-envelope me-2"></i>{{ Auth::user()->email }}
                            </p>
                            <p class="text-muted mb-0">
                                <i class="bi bi-person-badge me-2"></i>
                                <span class="text-capitalize">{{ Auth::user()->role }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs + Forms -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs nav-underline mb-4" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $errors->any() && count($errors->updatePassword) === 0 ? 'active' : '' }}"
                                id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">
                                <i class="bi bi-person me-2"></i>Update Profile
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $errors->any() && count($errors->updatePassword) > 0 ? 'active' : '' }}"
                                id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
                                <i class="bi bi-shield-lock me-2"></i>Update Password
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="profileTabsContent">
                        <!-- Profile Form -->
                        <div class="tab-pane fade {{ $errors->any() && count($errors->updatePassword) === 0 ? 'show active' : '' }}"
                            id="profile" role="tabpanel">
                            <form action="{{ route('profile.update') }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                @method('patch')

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" name="name" id="name"
                                            value="{{ old('name', Auth::user()->name) }}"
                                            class="form-control @error('name') is-invalid @enderror"
                                            required>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email"
                                            value="{{ old('email', Auth::user()->email) }}"
                                            class="form-control @error('email') is-invalid @enderror"
                                            required>
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="role" class="form-label">Role</label>
                                        <input type="text" id="role" value="{{ Auth::user()->role }}"
                                            class="form-control bg-light" disabled>
                                        <div class="form-text">Your role cannot be changed</div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-indigo">
                                                <i class="bi bi-check-circle me-2"></i>Update Profile
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Password Form -->
                        <div class="tab-pane fade {{ $errors->any() && count($errors->updatePassword) > 0 ? 'show active' : '' }}"
                            id="password" role="tabpanel">
                            <form action="{{ route('password.update') }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                @method('PUT')

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <div class="input-group">
                                            <input type="password" name="current_password" id="current_password"
                                                class="form-control @error('current_password') is-invalid @enderror"
                                                required>
                                            <button type="button" class="btn btn-outline-secondary toggle-password">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="password" class="form-label">New Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                required>
                                            <button type="button" class="btn btn-outline-secondary toggle-password">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-text">Password must be at least 8 characters long</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation" id="password_confirmation"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                required>
                                            <button type="button" class="btn btn-outline-secondary toggle-password">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-indigo">
                                                <i class="bi bi-key me-2"></i>Update Password
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-underline .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        color: #6c757d;
        font-weight: 500;
        padding: 0.75rem 1rem;
    }

    .nav-underline .nav-link.active {
        color: #6610f2;
        border-bottom-color: #6610f2;
        background: transparent;
    }

    .nav-underline .nav-link:hover {
        color: #6610f2;
        border-bottom-color: #dee2e6;
    }

    .btn-indigo {
        background-color: #6610f2;
        border-color: #6610f2;
        color: white;
    }

    .btn-indigo:hover {
        background-color: #520dc2;
        border-color: #520dc2;
        color: white;
    }

    .bg-indigo {
        background-color: #6610f2 !important;
    }

    .toggle-password {
        border-left: 0;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password toggle functionality
        const toggleButtons = document.querySelectorAll('.toggle-password');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });

        // Form validation
        const forms = document.querySelectorAll('.needs-validation');

        forms.forEach(form => {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    });
</script>
@endsection