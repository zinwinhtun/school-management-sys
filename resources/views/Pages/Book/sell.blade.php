@extends('layouts.app')

@section('content')


<div class="container">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-bag-plus"></i> Book Sell Form</h4>
        </div>

        <div class="card-body">
            {{-- Add Book Form --}}
            <form id="addForm" action="{{ route('books.addToSession') }}" method="POST" class="row g-3 needs-validation p-3 bg-light rounded shadow-sm" novalidate>
                @csrf

                {{-- Student --}}
                <div class="col-lg-4 col-md-6 col-12">
                    <label for="student_id" class="form-label fw-semibold">Student</label>
                    <input type="text" class="form-control mb-1" id="studentSearch" placeholder="Search student name...">
                    <select name="student_id" id="studentDropdown" class="form-select @error('student_id') is-invalid @enderror" required>
                        <option value="">Select student...</option>
                        @foreach ($students as $student)
                        <option value="{{ $student->id }}"
                            {{ session('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('student_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Book --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <label for="book_id" class="form-label fw-semibold">Book</label>
                    <select name="book_id" id="book_id" class="form-select @error('book_id') is-invalid @enderror" required>
                        <option value="">Select book...</option>
                        @foreach ($books as $book)
                        <option value="{{ $book->id }}" data-price="{{ $book->sell_price }}">
                            {{ $book->name }} ({{ number_format($book->sell_price, 2) }} Ks)
                        </option>
                        @endforeach
                    </select>
                    @error('book_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Quantity --}}
                <div class="col-lg-2 col-md-4 col-6">
                    <label for="quantity" class="form-label fw-semibold">Qty</label>
                    <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" min="1" required>
                    @error('quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Add button --}}
                <div class="col-lg-3 col-md-2 col-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100 py-2 shadow-sm">
                        <i class="bi bi-plus-circle me-1"></i> Add Book
                    </button>
                </div>
            </form>


            <hr>

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

{{-- Student live search --}}
<script>
    document.getElementById('studentSearch')?.addEventListener('input', function() {
        let filter = this.value.toLowerCase();
        let options = document.querySelectorAll('#studentDropdown option');
        options.forEach(opt => {
            if (opt.text.toLowerCase().includes(filter) || opt.value === "") {
                opt.style.display = '';
            } else {
                opt.style.display = 'none';
            }
        });
    });

    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()

    // Student live search
    document.getElementById('studentSearch')?.addEventListener('input', function() {
        let filter = this.value.toLowerCase()
        let options = document.querySelectorAll('#studentDropdown option')
        options.forEach(opt => {
            if(opt.text.toLowerCase().includes(filter) || opt.value === "") {
                opt.style.display = ''
            } else {
                opt.style.display = 'none'
            }
        })
    })
</script>

@endsection