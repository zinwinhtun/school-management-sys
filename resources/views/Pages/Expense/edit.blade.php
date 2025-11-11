@extends('layouts.app')

@section('content')
  <div class="container py-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-indigo text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Edit Expense Record</h3>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('expenses.update', $expense->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <!-- Title -->
                    <div class="col-md-6">
                        <label for="title" class="form-label fw-semibold">Expense Title</label>
                        <input type="text" name="title" id="title"
                            class="form-control @error('title') is-invalid @enderror"
                            placeholder="Enter Expense Title"
                            value="{{ old('title', $expense->title) }}">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div class="col-md-6">
                        <label for="amount" class="form-label fw-semibold">Amount</label>
                        <input type="number" name="amount" id="amount"
                            class="form-control @error('amount') is-invalid @enderror"
                            placeholder="10000.00 MMK"
                            value="{{ old('amount', $expense->amount) }}">
                        @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Note -->
                    <div class="col-md-12">
                        <label for="note" class="form-label fw-semibold">Note <span class="text-muted">Optional</span></label>
                        <textarea name="note" id="note"
                            class="form-control @error('note') is-invalid @enderror"
                            placeholder="Enter Note">{{ old('note', $expense->note) }}</textarea>
                        @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Update
                        </button>
                        <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary px-4 ms-2">
                            <i class="bi bi-arrow-left me-1"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection