@extends('layouts.app')

@section('content')


<div class="container">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-bag-plus"></i> Book Sell Form</h4>
        </div>

        <div class="card-body">
            {{-- Add Book Form --}}
            <form id="addForm"
                action="{{ route('books.addToSession') }}"
                method="POST"
                class="p-4 bg-white rounded-4 shadow-sm needs-validation"
                novalidate>
                @csrf

                <div class="d-flex flex-wrap gap-3 align-items-end">

                    <!-- Student -->
                    <div class="flex-grow-1 flex-shrink-1 min-w-200 col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold">Student</label>
                        <div class="dropdown w-100">
                            <button class="btn btn-light w-100 text-start dropdown-toggle border rounded-3 py-2 shadow-sm
                                @error('student_id') is-invalid @enderror"
                                type="button" id="studentDropdownBtn" data-bs-toggle="dropdown">
                                <span id="selectedStudent" class="{{ old('student_id') ? 'text-dark' : 'text-secondary' }}">
                                    {{ old('student_name', 'Select student') }}
                                </span>
                            </button>

                            <ul class="dropdown-menu w-100 p-3 rounded-3 shadow" style="max-height: 260px; overflow-y: auto;">
                                <li class="mb-2">
                                    <input type="text" id="studentSearch" class="form-control" placeholder="Search student...">
                                </li>

                                @foreach ($students as $student)
                                <li>
                                    <a class="dropdown-item py-2 rounded-2 student-option" href="#"
                                        data-id="{{ $student->id }}"
                                        data-name="{{ $student->name }}">
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

                    <!-- Book -->
                    <div class="flex-grow-1 flex-shrink-1 min-w-200 col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold">Book</label>
                        <div class="dropdown w-100">
                            <button class="btn btn-light w-100 text-start dropdown-toggle border rounded-3 py-2 shadow-sm
                                @error('book_id') is-invalid @enderror"
                                type="button" id="bookDropdownBtn" data-bs-toggle="dropdown">
                                <span id="selectedBook" class="text-secondary">
                                    {{ old('book_name', 'Select book') }}
                                </span>
                            </button>

                            <ul class="dropdown-menu w-100 p-3 rounded-3 shadow" style="max-height: 260px; overflow-y: auto;">
                                <li class="mb-2">
                                    <input type="text" id="bookSearch" class="form-control" placeholder="Search book...">
                                </li>

                                @foreach ($books as $book)
                                <li>
                                    <a class="dropdown-item py-2 rounded-2 book-option" href="#"
                                        data-id="{{ $book->id }}"
                                        data-name="{{ $book->name }}"
                                        data-price="{{ $book->sell_price }}">
                                        {{ $book->name }} ({{ number_format($book->sell_price, 2) }} Ks)
                                    </a>
                                </li>
                                @endforeach
                            </ul>

                            <input type="hidden" name="book_id" id="book_id" value="{{ old('book_id') }}">
                            @error('book_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div class="flex-shrink-0 min-w-100 col-12 col-sm-6 col-lg-2">
                        <label for="quantity" class="form-label fw-semibold">Qty</label>
                        <input type="number" name="quantity" id="quantity"
                            class="form-control @error('quantity') is-invalid @enderror"
                            min="1" required>
                        @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Add Button -->
                    <div class="flex-shrink-0 min-w-120 col-12 col-sm-6 col-lg-2 d-grid">
                        <button type="submit"
                            class="btn btn-success w-100 py-2 shadow-sm fw-semibold d-flex justify-content-center align-items-center">
                            <i class="bi bi-plus-circle me-2"></i> Add Book
                        </button>
                    </div>

                </div>
            </form>



            <hr class="my-4 text-muted">

            {{-- Cart Table --}}
            <div class="table-responsive">
                <table class="table table-striped align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Book</th>
                            <th>Qty</th>
                            <th>Sell Price</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grandTotal = 0; @endphp
                        @if(session('cart'))
                        @foreach(session('cart') as $index => $item)
                        @php $grandTotal += $item['total_price']; @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['book_title'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ number_format($item['price'], 2) }}</td>
                            <td>{{ number_format($item['total_price'], 2) }}</td>
                            <td>
                                <a href="{{ route('books.removeFromSession', $index) }}"
                                    class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6">No items in cart.</td>
                        </tr>
                        @endif
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="4" class="text-end fw-bold">Grand Total:</td>
                            <td class="fw-bold">{{ number_format($grandTotal, 2) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Save and Clear All Buttons (Right-aligned) --}}
            @if(session('cart'))
            <div class="d-flex justify-content-end gap-2 mt-3 flex-wrap">
                {{-- Save --}}
                <form action="{{ route('books.sell') }}" method="POST" class="m-0 p-0">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ session('student_id') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Sell
                    </button>
                </form>

                {{-- Clear All (trigger modal) --}}
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#clearCartModal">
                    <i class="bi bi-cart-x"></i> Clear All
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Clear Cart Modal --}}
<div class="modal fade" id="clearCartModal" tabindex="-1" aria-labelledby="clearCartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="clearCartModalLabel"><i class="bi bi-exclamation-triangle-fill"></i> Confirm Clear All</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to remove all items from the cart?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('books.clearCart') }}" method="POST" class="m-0 p-0">
                    @csrf
                    <button type="submit" class="btn btn-danger">Yes, Clear All</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Search function
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

    // Select option function
    function setupSelection(itemClass, inputId, displayId) {
        document.querySelectorAll('.' + itemClass).forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                let id = this.dataset.id;
                let name = this.dataset.name;

                document.getElementById(inputId).value = id;
                document.getElementById(displayId).textContent = name;
                document.getElementById(displayId).classList.remove('text-secondary');
                document.getElementById(displayId).classList.add('text-dark');
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {

        // Student dropdown
        setupSearch('studentSearch', 'student-option');
        setupSelection('student-option', 'student_id', 'selectedStudent');

        // Book dropdown
        setupSearch('bookSearch', 'book-option');
        setupSelection('book-option', 'book_id', 'selectedBook');
    });
</script>
@endpush