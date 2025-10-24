<div class="modal fade" id="createBookModal" tabindex="-1" aria-labelledby="createBookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="{{ route('books.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                <div class="modal-header bg-primary text-white py-3 rounded-top-4">
                    <h5 class="modal-title fw-semibold d-flex align-items-center">
                        <i class="bi bi-journal-plus me-2 fs-5"></i> Add New Book
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body bg-light p-4">
                    <div class="row g-4">
                        <!-- Book Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">
                                Book Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name"
                                value="{{ old('name') }}"
                                class="form-control form-control-lg rounded-3 shadow-sm @error('name') is-invalid @enderror"
                                placeholder="Enter book name" required>
                            @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <!-- Category -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Category</label>
                            <input type="text" name="category"
                                value="{{ old('category') }}"
                                class="form-control form-control-lg rounded-3 shadow-sm @error('category') is-invalid @enderror"
                                placeholder="Enter category">
                            @error('category') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <!-- Class -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Class</label>
                            <select name="class_id"
                                class="form-select form-select-lg rounded-3 shadow-sm @error('class_id') is-invalid @enderror">
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('class_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <!-- Purchase Price -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Purchase Price</label>
                            <div class="input-group shadow-sm rounded-3">
                                <span class="input-group-text bg-white border-end-0 rounded-start-3"><i class="bi bi-tags"></i></span>
                                <input type="number" step="0.01" name="purchase_price"
                                    value="{{ old('purchase_price') }}"
                                    class="form-control border-start-0 form-control-lg rounded-end-3 @error('purchase_price') is-invalid @enderror"
                                    placeholder="0.00">
                            </div>
                            @error('purchase_price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <!-- Sell Price -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Sell Price</label>
                            <div class="input-group shadow-sm rounded-3">
                                <span class="input-group-text bg-white border-end-0 rounded-start-3"><i class="bi bi-tags"></i></span>
                                <input type="number" step="0.01" name="sell_price"
                                    value="{{ old('sell_price') }}"
                                    class="form-control border-start-0 form-control-lg rounded-end-3 @error('sell_price') is-invalid @enderror"
                                    placeholder="0.00">
                            </div>
                            @error('sell_price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <!-- Stock -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Stock</label>
                            <input type="number" name="stock"
                                value="{{ old('stock') }}"
                                class="form-control form-control-lg rounded-3 shadow-sm @error('stock') is-invalid @enderror"
                                placeholder="Enter stock quantity">
                            @error('stock') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-white border-top-0 p-3">
                    <button type="button" class="btn btn-outline-secondary px-4 rounded-3" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3">
                        <i class="bi bi-save2 me-1"></i> Save Book
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
