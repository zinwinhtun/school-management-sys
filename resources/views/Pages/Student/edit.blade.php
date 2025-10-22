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

                    <!-- Class Select -->
                    <div class="col-md-6">
                        <label for="class" class="form-label fw-semibold">Class</label>
                        <select name="class_id" id="class" class="form-select @error('class_id') is-invalid @enderror">
                            <option value="">-- Select Class --</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('class_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                    <button type="submit" class="btn btn-success px-4">
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