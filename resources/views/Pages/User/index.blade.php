@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
<div class="container-fluid mb-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm p-3 rounded-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 flex-wrap">

                    <!-- Title -->
                    <div class="text-center text-md-start flex-grow-1">
                        <h3 class="fw-bold text-dark mb-1">
                            <i class="bi bi-people-fill text-primary me-2"></i>User Management
                        </h3>
                        <p class="text-muted small mb-0">
                            Manage users, roles, and permissions
                        </p>
                    </div>

                    <!-- Search + Add -->
                    <div class="w-100 w-md-auto">
                        <div class="row g-2 align-items-center">
                            
                            <!-- Search Bar -->
                            <div class="col-12 col-md-8">
                                <form method="GET" action="{{ route('users.index') }}" class="position-relative">
                                    <input type="text"
                                        class="form-control form-control-lg bg-light border-0 ps-4 pe-5 rounded-3 shadow-sm"
                                        name="search"
                                        value="{{ request('search') }}"
                                        placeholder="Search users...">
                                    <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                                </form>
                            </div>

                            <!-- Add User Button -->
                            <div class="col-12 col-md-4">
                                <button class="btn btn-primary btn-lg fw-semibold w-100 shadow-sm rounded-3"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#createUserModal">
                                    <i class="bi bi-plus-circle me-2"></i>Add User
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- User Table -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0 text-dark">
                    <i class="bi bi-list-check text-indigo me-2"></i>Users List
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="usersTable">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 ps-4 py-3 fw-semibold text-dark text-nowrap">
                                    <i class="bi bi-person me-1"></i>Name
                                </th>
                                <th class="border-0 py-3 fw-semibold text-dark text-nowrap">
                                    <i class="bi bi-envelope me-1"></i>Email
                                </th>
                                <th class="border-0 py-3 fw-semibold text-dark text-nowrap">
                                    <i class="bi bi-shield me-1"></i>Role
                                </th>
                                <th class="border-0 py-3 fw-semibold text-dark text-center text-nowrap">
                                    <i class="bi bi-gear me-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr class="user-row" data-user-name="{{ strtolower($user->name) }}" data-user-email="{{ strtolower($user->email) }}">
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-indigo bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3"
                                            style="width: 40px; height: 40px;">
                                            <span class="text-indigo fw-bold">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold text-dark">{{ $user->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="text-muted">{{ $user->email }}</span>
                                </td>
                                <td class="py-3">
                                    <span class="badge fs-6 py-2 px-3 {{ $user->role === 'admin' ? 'bg-indigo' : 'bg-success' }}">
                                        <i class="bi {{ $user->role === 'admin' ? 'bi-shield-check' : 'bi-person-check' }} me-1"></i>
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="py-3 text-center">
                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                        <button class="btn btn-sm btn-outline-indigo rounded-pill edit-user-btn px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editUserModal"
                                            data-user-id="{{ $user->id }}"
                                            data-user-name="{{ $user->name }}"
                                            data-user-email="{{ $user->email }}"
                                            data-user-role="{{ $user->role }}">
                                            <i class="bi bi-pencil-square me-1"></i>Edit
                                        </button>
                                        @if($user->id !== Auth::id())
                                        <button class="btn btn-sm btn-outline-danger rounded-pill delete-user-btn px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteUserModal"
                                            data-user-id="{{ $user->id }}"
                                            data-user-name="{{ $user->name }}">
                                            <i class="bi bi-trash me-1"></i>Delete
                                        </button>
                                        @else
                                        <span class="badge bg-secondary rounded-pill px-3 py-2">Current User</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="bi bi-people display-4 text-muted d-block mb-3"></i>
                                    <h5 class="text-muted">No users found</h5>
                                    <p class="text-muted">Get started by adding your first user</p>
                                    <button class="btn btn-indigo" data-bs-toggle="modal" data-bs-target="#createUserModal">
                                        <i class="bi bi-plus-circle me-2"></i>Add First User
                                    </button>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                <div class="card-footer bg-transparent border-0 py-4">
                    <div class="d-flex justify-content-between align-items-center flex-column flex-md-row gap-3">
                        <div class="text-muted text-center text-md-start">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                        </div>
                        <div>
                            {{ $users->appends(['search' => request('search')])->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-indigo text-white">
                <h5 class="modal-title" id="createUserModalLabel">
                    <i class="bi bi-plus-circle me-2"></i>Add New User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST" id="createUserForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="create_name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg border-0 bg-light"
                                id="create_name" name="name" required placeholder="Enter full name">
                        </div>
                        <div class="col-12">
                            <label for="create_email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-lg border-0 bg-light"
                                id="create_email" name="email" required placeholder="Enter email address">
                        </div>
                        <div class="col-12">
                            <label for="create_password" class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg border-0 bg-light"
                                    id="create_password" name="password" required placeholder="Enter password">
                                <button type="button" class="btn btn-outline-secondary border-0 bg-light toggle-password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="create_password_confirmation" class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg border-0 bg-light"
                                    id="create_password_confirmation" name="password_confirmation" required placeholder="Confirm password">
                                <button type="button" class="btn btn-outline-secondary border-0 bg-light toggle-password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="create_role" class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg border-0 bg-light" id="create_role" name="role" required>
                                <option value="">Select Role</option>
                                <option value="admin">Administrator</option>
                                <option value="staff">Staff Member</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light rounded-bottom">
                    <button type="button" class="btn btn-lg btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-lg btn-indigo rounded-pill px-4">
                        <i class="bi bi-plus-circle me-2"></i>Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-indigo  text-dark">
                <h5 class="modal-title text-light" id="editUserModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>Edit User
                </h5>
                <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_user_id" name="user_id">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="edit_name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg border-0 bg-light"
                                id="edit_name" name="name" required>
                        </div>
                        <div class="col-12">
                            <label for="edit_email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-lg border-0 bg-light"
                                id="edit_email" name="email" required>
                        </div>
                        <div class="col-12">
                            <label for="edit_role" class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg border-0 bg-light" id="edit_role" name="role" required>
                                <option value="admin">Administrator</option>
                                <option value="staff">Staff Member</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light rounded-bottom">
                    <button type="button" class="btn btn-lg btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-lg btn-warning text-dark rounded-pill px-4">
                        <i class="bi bi-check-circle me-2"></i>Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteUserModalLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirm Delete
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <i class="bi bi-trash display-4 text-danger d-block mb-3"></i>
                <h5 class="fw-semibold mb-3">Delete User</h5>
                <p class="mb-4">Are you sure you want to delete user "<span id="deleteUserName" class="fw-bold text-danger"></span>"?</p>
                <p class="text-muted small mb-0">This action cannot be undone and will permanently remove the user from the system.</p>
            </div>
            <div class="modal-footer border-0 bg-light rounded-bottom justify-content-center">
                <button type="button" class="btn btn-lg btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteUserForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="delete_user_id" name="user_id">
                    <button type="submit" class="btn btn-lg btn-danger rounded-pill px-4">
                        <i class="bi bi-trash me-2"></i>Delete User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-indigo {
        background-color: #6610f2 !important;
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

    .btn-outline-indigo {
        color: #6610f2;
        border-color: #6610f2;
    }

    .btn-outline-indigo:hover {
        background-color: #6610f2;
        border-color: #6610f2;
        color: white;
    }

    .card {
        border-radius: 1rem;
    }

    .modal-content {
        border-radius: 1rem;
    }

    .table th {
        border-top: none;
        font-weight: 600;
    }

    .user-row:hover {
        background-color: #f8f9fa;
    }

    .form-control:focus,
    .form-select:focus {
        box-shadow: 0 0 0 0.2rem rgba(102, 16, 242, 0.25);
        border-color: #6610f2;
    }

    /* Small responsive tweaks */
    @media (max-width: 576px) {
        .btn-indigo {
            font-size: 1rem;
            padding: 0.75rem 1rem;
        }

        input.form-control-lg {
            font-size: 1rem;
            height: auto;
        }
    }

    /* Responsive polish */
    @media (max-width: 576px) {
        .btn {
            font-size: 1rem;
            padding: 0.75rem 1rem;
        }

        input.form-control-lg {
            font-size: 1rem;
            height: auto;
        }
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

        // Edit user modal event listener
        const editUserModal = document.getElementById('editUserModal');
        if (editUserModal) {
            editUserModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // Button that triggered the modal
                const userId = button.getAttribute('data-user-id');
                const userName = button.getAttribute('data-user-name');
                const userEmail = button.getAttribute('data-user-email');
                const userRole = button.getAttribute('data-user-role');

                // Update the modal's content
                document.getElementById('edit_user_id').value = userId;
                document.getElementById('edit_name').value = userName;
                document.getElementById('edit_email').value = userEmail;
                document.getElementById('edit_role').value = userRole;

                // Update form action
                const form = document.getElementById('editUserForm');
                form.action = `/users/${userId}`;
            });
        }

        // Delete user modal event listener
        const deleteUserModal = document.getElementById('deleteUserModal');
        if (deleteUserModal) {
            deleteUserModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // Button that triggered the modal
                const userId = button.getAttribute('data-user-id');
                const userName = button.getAttribute('data-user-name');

                // Update the modal's content
                document.getElementById('delete_user_id').value = userId;
                document.getElementById('deleteUserName').textContent = userName;

                // Update form action
                const form = document.getElementById('deleteUserForm');
                form.action = `/users/${userId}`;
            });
        }

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                const rows = document.querySelectorAll('.user-row');

                rows.forEach(row => {
                    const name = row.getAttribute('data-user-name');
                    const email = row.getAttribute('data-user-email');

                    if (name.includes(searchTerm) || email.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }

        // Form validation for create user
        const createForm = document.getElementById('createUserForm');
        if (createForm) {
            createForm.addEventListener('submit', function(e) {
                const password = document.getElementById('create_password').value;
                const confirmPassword = document.getElementById('create_password_confirmation').value;

                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Passwords do not match!');
                    return false;
                }

                if (password.length < 8) {
                    e.preventDefault();
                    alert('Password must be at least 8 characters long!');
                    return false;
                }
            });
        }
    });
</script>
@endsection