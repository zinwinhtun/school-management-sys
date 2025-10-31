@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-indigo text-white d-flex flex-column flex-md-row justify-content-between align-items-center">
            <h4 class="mb-2 mb-md-0"><i class="bi bi-clock-history me-2"></i>Sell History</h4>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('books.sellForm') }}" class="btn btn-indigo text-light btn-sm">
                    <i class="bi bi-bag-plus me-1"></i> Sell Book
                </a>
            </div>
        </div>

        <div class="card-body">

            {{-- Filter Form --}}
            <form method="GET" action="{{ route('books.sellHistory') }}" class="row g-2 mb-3">
                <div class="col-12 col-md-3">
                    <label for="student_id" class="form-label small mb-1">Student</label>
                    <select name="student_id" id="student_id" class="form-select">
                        <option value="">All Students</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-3">
                    <label for="book_id" class="form-label small mb-1">Book</label>
                    <select name="book_id" id="book_id" class="form-select">
                        <option value="">All Books</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}" {{ request('book_id') == $book->id ? 'selected' : '' }}>
                                {{ $book->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-2">
                    <label for="start_date" class="form-label small mb-1">From</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                </div>

                <div class="col-6 col-md-2">
                    <label for="end_date" class="form-label small mb-1">To</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                </div>

                <div class="col-12 col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel-fill me-1"></i> Filter
                    </button>
                </div>
            </form>

            {{-- Sell History Table --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Book</th>
                            <th>Qty</th>
                            <th>Sell Price</th>
                            <th>Total</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sells as $index => $sell)
                            <tr>
                                <td>{{ $sells->firstItem() + $index }}</td>
                                <td>{{ $sell->student->name ?? '-' }}</td>
                                <td>{{ $sell->book->name ?? '-' }}</td>
                                <td>{{ $sell->quantity }}</td>
                                <td>{{ number_format($sell->book->sell_price, 2) }}</td>
                                <td>{{ number_format($sell->total_price, 2) }}</td>
                                <td>{{ $sell->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}

                @if($sells->hasPages())
            <div class="card-footer bg-transparent border-0 py-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                    <small class="text-muted">
                        Showing <strong>{{ $sells->firstItem() }}</strong> to
                        <strong>{{ $sells->lastItem() }}</strong> of
                        <strong>{{ $sells->total() }}</strong> results
                    </small>
                    {{ $sells->links() }}
                </div>
            </div>
            @endif
         
        </div>
    </div>
</div>

@endsection
