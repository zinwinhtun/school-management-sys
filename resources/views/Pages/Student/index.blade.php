@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="container-fluid mb-4 px-2 px-sm-3 px-md-4">
        <div class="row align-items-center">

            <!-- Title Section -->
            <div class="col-12 col-sm-6 col-lg-8 mb-2 mb-sm-0">
                <div class="d-flex align-items-center justify-content-center justify-content-sm-start">
                    <h2 class="fw-bold text-primary mb-0 d-flex align-items-center">
                        <i class="bi bi-people-fill me-2 fs-4 fs-md-3 fs-lg-2"></i>
                        <span class="fs-5 fs-md-4 fs-lg-3">Student List</span>
                    </h2>
                </div>
            </div>

            <!-- Buttons Section -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center justify-content-sm-end">

                    <!-- Add Student Button -->
                    <a href="{{route('student.create')}}"
                        class="btn btn-primary d-flex align-items-center justify-content-center fw-semibold">
                        <i class="bi bi-person-plus me-1 me-sm-2"></i>
                        <span class="d-none d-sm-inline">Add Student</span>
                        <span class="d-inline d-sm-none">Add</span>
                    </a>

                    <!-- Add Class Button -->
                    <a href="#"
                        class="btn btn-primary d-flex align-items-center justify-content-center fw-semibold"
                        data-bs-toggle="modal"
                        data-bs-target="#createClassModal">
                        <i class="bi bi-journal-plus me-1 me-sm-2"></i>
                        <span class="d-none d-sm-inline">Add Class</span>
                        <span class="d-inline d-sm-none">Class</span>
                    </a>

                    <!-- Create Class Modal -->
                    <div class="modal fade" id="createClassModal" tabindex="-1" aria-labelledby="createClassModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg rounded-3">
                                <div class="modal-header bg-indigo text-white">
                                    <h5 class="modal-title fw-semibold" id="createClassModalLabel">
                                        <i class="bi bi-journal-plus me-2"></i> Add New Class
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form action="{{ route('class.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="className" class="form-label fw-semibold">Class Name</label>
                                            <input type="text" name="name" id="className" class="form-control" placeholder="Enter class name" required>
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="modal-footer d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="bi bi-x-circle me-1"></i> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle me-1"></i> Save Class
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-0 py-3 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <span class="fw-semibold text-muted">Total Students – </span>
                <span class="fw-bold text-primary">{{ $students->total() }}</span>
            </div>

            <!-- Search Form -->
            <form action="#" method="GET" class="d-flex">
                <div class="input-group" style="max-width: 300px;">
                    <input type="text"
                        class="form-control rounded-start-pill"
                        placeholder="Search student..."
                        aria-label="Search"
                        name="search"
                        value="{{ request('search') }}">
                    <button class="btn btn-primary rounded-end-pill px-3" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 60px;">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Class</th>
                            <th scope="col">Parent Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Address</th>
                            <th scope="col" class="text-center" style="width: 150px;">Tools</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                        <tr>
                            <th scope="row">{{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}</th>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2"
                                        style="width: 35px; height: 35px;">
                                        <span class="text-primary fw-bold small">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold text-dark small">{{ $student->name }}</h6>
                                        <small class="text-muted">{{ $student->email ?? 'No email' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $student->classType->name ?? 'No Class' }}
                                </span>
                            </td>
                            <td>
                                <span class="text-dark small">{{ $student->parent_name ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="text-muted small">{{ $student->phone ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="text-muted small">
                                    {{ \Illuminate\Support\Str::limit($student->address, 30) ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-1">

                                    <!-- View Details Button -->
                                    <a href="#"
                                        class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center"
                                        data-bs-toggle="tooltip"
                                        title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="#" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center"
                                            data-bs-toggle="tooltip"
                                            title="Delete Student"
                                            onclick="return confirm('Are you sure you want to delete {{ $student->name }}?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-people display-4 text-muted d-block mb-3"></i>
                                <h5 class="text-muted">
                                    @if(request('search'))
                                    No students found for "{{ request('search') }}"
                                    @else
                                    No students found
                                    @endif
                                </h5>
                                <p class="text-muted">Get started by adding your first student</p>
                                <a href="#" class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-circle me-2"></i>Add First Student
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($students->hasPages())
            <div class="card-footer bg-transparent border-0 py-4">
                <div class="d-flex justify-content-between align-items-center flex-column flex-md-row gap-3">
                    <div class="text-muted text-center text-md-start">
                        <small>
                            Showing <strong>{{ $students->firstItem() }}</strong> to
                            <strong>{{ $students->lastItem() }}</strong> of
                            <strong>{{ $students->total() }}</strong> results
                        </small>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Initialize Tooltips -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>

@endsection