@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-indigo text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Create Student Form</h3>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('student.store') }}" method="POST" novalidate>
                @csrf
                <div class="row g-3">
                    <!-- Student Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">Student Name</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Enter student name" value="{{ old('name') }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Class -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Class</label>

                    <div class="dropdown w-100">
                        <button class="btn btn-light w-100 text-start dropdown-toggle border rounded-3 py-2 shadow-sm 
                            @error('class_id') is-invalid @enderror"
                            type="button" id="classDropdown" data-bs-toggle="dropdown">

                            <span id="selectedClass" class="{{ old('class_id') ? 'text-dark' : 'text-secondary' }}">
                                {{ old('class_name', 'Select class') }}
                            </span>
                        </button>

                        <ul class="dropdown-menu w-100 p-3 rounded-3 shadow" style="max-height: 260px; overflow-y: auto;">
                            <li class="mb-2">
                                <div class="input-group">
                                    <input type="text" id="classSearch" class="form-control" placeholder="Search class...">
                                </div>
                            </li>

                            @foreach ($classes as $class)
                            <li>
                                <a class="dropdown-item py-2 rounded-2 class-option" href="#"
                                    data-id="{{ $class->id }}"
                                    data-name="{{ $class->name }}">
                                    {{ $class->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>

                        <input type="hidden" name="class_id" id="class_id" value="{{ old('class_id') }}">
                        @error('class_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-semibold">Phone</label>
                        <input type="text" name="phone" id="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            placeholder="09xxxxxxxxx" value="{{ old('phone') }}">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Parent Name -->
                    <div class="col-md-6">
                        <label for="parent_name" class="form-label fw-semibold">Parent Name</label>
                        <input type="text" name="parent_name" id="parent_name"
                            class="form-control @error('parent_name') is-invalid @enderror"
                            placeholder="Enter parent name" value="{{ old('parent_name') }}">
                        @error('parent_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div class="col-md-6">
                        <label for="date_of_birth" class="form-label fw-semibold">Date of Birth</label>
                        <input type="date" name="date_of_birth" id="date_of_birth"
                            class="form-control @error('date_of_birth') is-invalid @enderror"
                            value="{{ old('date_of_birth') }}">
                        @error('date_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="col-md-6">
                        <label for="address" class="form-label fw-semibold">Address</label>
                        <input type="text" name="address" id="address"
                            class="form-control @error('address') is-invalid @enderror"
                            placeholder="Enter address" value="{{ old('address') }}">
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Submit
                    </button>
                    <button type="reset" class="btn btn-outline-secondary px-4 ms-2">
                        <i class="bi bi-arrow-clockwise me-1"></i> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    //  Search filter
    function setupSearch(inputId, itemClass) {
        const input = document.getElementById(inputId);
        input.addEventListener('keyup', function() {
            const search = this.value.toLowerCase();
            document.querySelectorAll('.' + itemClass).forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(search) ? '' : 'none';
            });
        });
    }

    //  Select item & set hidden input
    function setupSelection(itemClass, inputId, displayId) {
        document.querySelectorAll('.' + itemClass).forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const name = this.textContent;
                document.getElementById(inputId).value = id;
                document.getElementById(displayId).textContent = name;
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        setupSearch('classSearch', 'class-option');
        setupSelection('class-option', 'class_id', 'selectedClass');
    });

    document.querySelectorAll('.class-option').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('class_id').value = this.dataset.id;
            document.getElementById('selectedClass').textContent = this.dataset.name;
            document.getElementById('selectedClass').classList.remove('text-secondary');
        });
    });
</script>
@endpush