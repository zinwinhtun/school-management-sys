@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-clock-history me-2"></i>Sell History</h4>
            <a href="{{ route('books.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-book me-1"></i> Book List
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle text-center">
                    <thead class="table-dark">
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
            <div class="d-flex justify-content-end mt-3">
                {{ $sells->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
