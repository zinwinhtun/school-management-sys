@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-indigo text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0 text-uppercase">Student information & update</h3>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('student.update', $student->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT') <!-- Update method -->
                <div class="row g-3">
                    <!-- Student Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">Student Name</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Enter student name"
                            value="{{ old('name', $student->name) }}">
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

                                <span id="selectedClass" class="text-dark">
                                    {{ old('class_name', $student->class->name ?? 'Select class') }}
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

                            <input type="hidden" name="class_id" id="class_id" value="{{ old('class_id', $student->class_id) }}">
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
                            placeholder="09xxxxxxxxx" value="{{ old('phone', $student->phone) }}">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Parent Name -->
                    <div class="col-md-6">
                        <label for="parent_name" class="form-label fw-semibold">Parent Name</label>
                        <input type="text" name="parent_name" id="parent_name"
                            class="form-control @error('parent_name') is-invalid @enderror"
                            placeholder="Enter parent name" value="{{ old('parent_name', $student->parent_name) }}">
                        @error('parent_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div class="col-md-6">
                        <label for="date_of_birth" class="form-label fw-semibold">Date of Birth</label>
                        <input type="date" name="date_of_birth" id="date_of_birth"
                            class="form-control @error('date_of_birth') is-invalid @enderror"
                            value="{{ old('date_of_birth', $student->date_of_birth) }}">
                        @error('date_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="col-md-6">
                        <label for="address" class="form-label fw-semibold">Address</label>
                        <input type="text" name="address" id="address"
                            class="form-control @error('address') is-invalid @enderror"
                            placeholder="Enter address" value="{{ old('address', $student->address) }}">
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-pencil-square me-1"></i> Update
                    </button>
                    <a href="{{ route('student.index') }}" class="btn btn-outline-secondary px-4 ms-2">
                        Cancel
                    </a>
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

    document.addEventListener('DOMContentLoaded', function() {
        let selectedId = document.getElementById('class_id').value;

        if (selectedId) {
            let selectedItem = document.querySelector(`.class-option[data-id="${selectedId}"]`);
            if (selectedItem) {
                document.getElementById('selectedClass').textContent = selectedItem.dataset.name;
                document.getElementById('selectedClass').classList.remove('text-secondary');
                document.getElementById('selectedClass').classList.add('text-dark');
            }
        }

        // dropdown click handler
        document.querySelectorAll('.class-option').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                let id = this.dataset.id;
                let name = this.dataset.name;

                document.getElementById('class_id').value = id;
                document.getElementById('selectedClass').textContent = name;
                document.getElementById('selectedClass').classList.remove('text-secondary');
                document.getElementById('selectedClass').classList.add('text-dark');
            });
        });
    });
</script>
@endpush