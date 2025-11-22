@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0 rounded-4 overflow-hidden">

        <div class="card-header bg-indigo text-white py-3">
            <h3 class="mb-0 fw-bold">Fee Collect & Refund</h3>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('collect.store') }}" method="POST" class="row g-4">
                @csrf

                <!-- Student -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Student</label>

                    <div class="dropdown w-100">
                        <button class="btn btn-light w-100 text-start dropdown-toggle border rounded-3 py-2 shadow-sm 
                            @error('student_id') is-invalid @enderror"
                            type="button" id="studentDropdown" data-bs-toggle="dropdown">
                            <span id="selectedStudent" class="{{ old('student_id') ? 'text-dark' : 'text-secondary' }}">
                                {{ old('student_name', 'Select student') }}
                            </span>
                        </button>

                        <ul class="dropdown-menu w-100 p-3 rounded-3 shadow" style="max-height: 260px; overflow-y: auto;">
                            <li class="mb-2">
                                <div class="input-group">
                                    <input type="text" id="studentSearch" class="form-control rounded-start" placeholder="Search student...">
                                    <a href="{{route('student.create')}}"><button class="btn btn-outline-primary rounded-end" type="button" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                                            <i class="bi bi-plus-lg"></i>
                                        </button></a>
                                </div>
                            </li>

                            @foreach ($students as $student)
                            <li>
                                <a class="dropdown-item student-option" href="#"
                                    data-id="{{ $student->id }}"
                                    data-name="{{ $student->name }}"
                                    data-class-id="{{ $student->class_id }}"
                                    data-class-name="{{ $student->classType->name }}">
                                    {{ $student->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>

                        <input type="hidden" name="student_id" id="student_id" value="{{ old('student_id') }}">
                        @error('student_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
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


                <!-- Title -->
                <div class="col-md-12 mt-3">
                    <label class="form-label fw-semibold">Fee Title</label>
                    <input type="text" name="title"
                        class="form-control rounded-3 shadow-sm @error('title') is-invalid @enderror"
                        value="{{ old('title') }}"
                        placeholder="Enter fee title">

                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Total Amount -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Total Amount</label>
                    <input type="number" name="total_amount" step="0.01"
                        class="form-control rounded-3 shadow-sm @error('total_amount') is-invalid @enderror"
                        value="{{ old('total_amount') }}"
                        placeholder="Enter total amount">

                    @error('total_amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Amount -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Collect Amount</label>
                    <input type="number" name="amount" step="0.01"
                        class="form-control rounded-3 shadow-sm @error('amount') is-invalid @enderror"
                        value="{{ old('amount') }}"
                        placeholder="Enter collect amount">

                    @error('amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Note</label>
                    <textarea name="note"
                        class="form-control rounded-3 shadow-sm @error('note') is-invalid @enderror"
                        rows="3"
                        placeholder="Optional...">{{ old('note') }}</textarea>

                    @error('note')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Buttons -->
                <div class="col-12 text-end mt-3 d-flex justify-content-end gap-2">
                    <!-- Back Button -->
                    <a href="{{ url()->previous() }}" class="btn btn-secondary px-4 py-2 rounded-3 shadow-sm fw-semibold">
                        Back
                    </a>

                    <!-- Submit Button -->
                    <button class="btn btn-primary px-4 py-2 rounded-3 shadow-sm fw-semibold">
                        Save Fee
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


    setupSearch('studentSearch', 'student-option');
    setupSearch('classSearch', 'class-option');

    setupSelection('student-option', 'student_id', 'selectedStudent');
    setupSelection('class-option', 'class_id', 'selectedClass');


    document.querySelectorAll('.student-option').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('student_id').value = this.dataset.id;
            document.getElementById('selectedStudent').textContent = this.dataset.name;
            document.getElementById('selectedStudent').classList.remove('text-secondary');
        });
    });

    document.querySelectorAll('.class-option').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('class_id').value = this.dataset.id;
            document.getElementById('selectedClass').textContent = this.dataset.name;
            document.getElementById('selectedClass').classList.remove('text-secondary');
        });
    });

    // student selection
    document.querySelectorAll('.student-option').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const studentId = this.dataset.id;
            const studentName = this.dataset.name;
            const studentClassId = this.dataset.classId || '';
            const studentClassName = this.dataset.className || '';

            // set selected student
            document.getElementById('student_id').value = studentId;
            document.getElementById('selectedStudent').textContent = studentName;
            document.getElementById('selectedStudent').classList.remove('text-secondary');

            // set related class
            if (studentClassId) {
                document.getElementById('class_id').value = studentClassId;
                document.getElementById('selectedClass').textContent = studentClassName;
                document.getElementById('classDropdown').classList.remove('text-secondary');

                // disable class selection
                document.getElementById('classDropdown').disabled = true;
            } else {
                document.getElementById('class_id').value = '';
                document.getElementById('selectedClass').textContent = 'Select class';
                document.getElementById('classDropdown').classList.add('text-secondary');
                document.getElementById('classDropdown').disabled = false;
            }
        });
    });

    // if user clicks class dropdown manually (only possible if enabled)
    document.getElementById('classDropdown').addEventListener('click', function() {
        if (this.disabled) this.blur(); // prevent opening dropdown if disabled
    });
</script>
@endpush