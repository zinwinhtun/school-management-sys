@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="container-fluid mb-4 px-3">
        <div class="row align-items-center gy-2">
            <div class="col-12 col-md-8 text-center text-md-start">
                <h2 class="fw-bold text-primary mb-0">
                    <i class="bi bi-book-half me-2"></i> Edit Book
                </h2>
            </div>
        </div>
    </div>

    <!-- Edit Book Form -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('books.update', $book->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                <div class="row g-4">

                    <!-- Book Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold text-secondary">
                            Book Name <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control form-control rounded-3 shadow-sm @error('name') is-invalid @enderror"
                            placeholder="Enter book name"
                            value="{{ old('name', $book->name) }}"
                            required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="col-md-6">
                        <label for="category" class="form-label fw-semibold text-secondary">
                            Category
                        </label>
                        <input
                            type="text"
                            id="category"
                            name="category"
                            class="form-control form-control rounded-3 shadow-sm @error('category') is-invalid @enderror"
                            placeholder="Enter category"
                            value="{{ old('category', $book->category) }}">
                        @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Class -->
                    <div class="col-md-6">
                        <label for="class_id" class="form-label fw-semibold text-secondary">
                            Class
                        </label>
                        <select
                            id="class_id"
                            name="class_id"
                            class="form-select form-select rounded-3 shadow-sm @error('class_id') is-invalid @enderror">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}"
                                {{ old('class_id', $book->class_id) == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('class_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Purchase Price -->
                    <div class="col-md-6">
                        <label for="purchase_price" class="form-label fw-semibold text-secondary">
                            Purchase Price
                        </label>
                        <div class="input-group shadow-sm rounded-3">
                            <span class="input-group-text bg-white border-end-0 rounded-start-3">
                                <i class="bi bi-currency-dollar"></i>
                            </span>
                            <input
                                type="number"
                                step="0.01"
                                id="purchase_price"
                                name="purchase_price"
                                class="form-control border-start-0 form-control rounded-end-3 @error('purchase_price') is-invalid @enderror"
                                placeholder="0.00"
                                value="{{ old('purchase_price', $book->purchase_price) }}">
                        </div>
                        @error('purchase_price')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sell Price -->
                    <div class="col-md-6">
                        <label for="sell_price" class="form-label fw-semibold text-secondary">
                            Sell Price
                        </label>
                        <div class="input-group shadow-sm rounded-3">
                            <span class="input-group-text bg-white border-end-0 rounded-start-3">
                                <i class="bi bi-cash-coin"></i>
                            </span>
                            <input
                                type="number"
                                step="0.01"
                                id="sell_price"
                                name="sell_price"
                                class="form-control border-start-0 form-control rounded-end-3 @error('sell_price') is-invalid @enderror"
                                placeholder="0.00"
                                value="{{ old('sell_price', $book->sell_price) }}">
                        </div>
                        @error('sell_price')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div class="col-md-6">
                        <label for="stock" class="form-label fw-semibold text-secondary">
                            Stock
                        </label>
                        <input
                            type="number"
                            id="stock"
                            name="stock"
                            class="form-control form-control rounded-3 shadow-sm @error('stock') is-invalid @enderror"
                            placeholder="Enter stock quantity"
                            value="{{ old('stock', $book->stock) }}">
                        @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <!-- Action Buttons -->
                <div class="mt-4">
                    <div class="row g-2 justify-content-end align-items-center">

                        <!-- Back Button -->
                        <div class="col-12 col-md-auto">
                            <a href="{{ route('books.index') }}" class="btn btn-outline-secondary btn-md w-100 px-4">
                                <i class="bi bi-arrow-left-circle me-1"></i> Back
                            </a>
                        </div>

                        <!-- Update Button -->
                        <div class="col-12 col-md-auto">
                            <button type="submit" class="btn btn-primary btn-md w-100 px-4">
                                <i class="bi bi-save2 me-1"></i> Update Book
                            </button>
                        </div>

                    </div>
                </div>


            </form>

        </div>
    </div>
</div>

@endsection