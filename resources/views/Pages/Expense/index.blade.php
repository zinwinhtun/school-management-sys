@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="container-fluid mb-4 px-2 px-sm-3 px-md-4">
        <div class="row align-items-center">

            <!-- Title Section -->
            <div class="col-12 col-sm-6 col-lg-8 mb-2 mb-sm-0">
                <div class="d-flex align-items-center justify-content-center justify-content-sm-start">
                    <h2 class="fw-bold text-primary mb-0 d-flex align-items-center">
                        <i class="bi bi-wallet2 me-2 fs-4 fs-md-3 fs-lg-2"></i>
                        <span class="fs-5 fs-md-4 fs-lg-3">Expense List</span>
                    </h2>
                </div>
            </div>

            <!-- Buttons Section -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center justify-content-sm-end">
                    <a href="{{ route('expenses.create') }}"
                        class="btn btn-primary d-flex align-items-center justify-content-center fw-semibold">
                        <i class="bi bi-plus-circle me-1 me-sm-2"></i>
                        <span class="d-none d-sm-inline">Add Expense</span>
                        <span class="d-inline d-sm-none">Add</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div
            class="card-header bg-white border-0 py-3 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <span class="fw-semibold text-muted">Total Expenses Record – </span>
                <span class="fw-bold text-primary">{{ $expenses->total() }}</span>
            </div>

            <!-- Search Form -->
            <form action="{{ route('expenses.index') }}" method="GET" class="d-flex">
                <div class="input-group" style="max-width: 300px;">
                    <input type="text"
                        class="form-control rounded-start-pill"
                        placeholder="Search expense..."
                        aria-label="Search"
                        name="search"
                        value="{{ request('search') }}">
                    <button class="btn btn-primary rounded-end-pill px-3" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Expenses Table -->
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Note</th>
                                <th>Date</th>
                                <th class="text-center" style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($expenses as $expense)
                            <tr>
                                <th scope="row">{{ ($expenses->currentPage() - 1) * $expenses->perPage() + $loop->iteration }}</th>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h6 class="mb-0 fw-semibold text-dark small">{{ $expense->title }}</h6>
                                        </div>
                                    </div>
                                </td>

                                <td><span class="fw-semibold text-primary">{{ number_format($expense->amount, 0) }} MMK</span></td>
                                <td><span class="text-muted small">{{ \Illuminate\Support\Str::limit($expense->note, 40) ?? '-' }}</span></td>
                                <td><span class="text-muted small">{{ $expense->created_at->format('Y-m-d') }}</span></td>

                                <td class="text-center">
                                    <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-1">
                                        <!-- Edit -->
                                        <a href="{{ route('expenses.edit', $expense->id) }}"
                                            class="btn btn-outline-warning btn-sm d-flex align-items-center justify-content-center"
                                            data-bs-toggle="tooltip" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Delete -->
                                        <button type="button"
                                            class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteExpenseModal{{ $expense->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteExpenseModal{{ $expense->id }}" tabindex="-1"
                                            aria-labelledby="deleteExpenseModalLabel{{ $expense->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteExpenseModalLabel{{ $expense->id }}">
                                                                Delete Expense
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete <strong>{{ $expense->title }}</strong>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-wallet2 display-4 text-muted d-block mb-3"></i>
                                    <h5 class="text-muted">
                                        @if(request('search'))
                                        No expenses found for "{{ request('search') }}"
                                        @else
                                        No expenses found
                                        @endif
                                    </h5>
                                    <p class="text-muted">Add your first expense to get started</p>
                                    <a href="{{ route('expenses.create') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-circle me-2"></i>Add Expense
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($expenses->hasPages())
                <div class="card-footer bg-transparent border-0 py-4">
                    <div class="d-flex justify-content-between align-items-center flex-column flex-md-row gap-3">
                        <div class="text-muted text-center text-md-start">
                            <small>
                                Showing <strong>{{ $expenses->firstItem() }}</strong> to
                                <strong>{{ $expenses->lastItem() }}</strong> of
                                <strong>{{ $expenses->total() }}</strong> results
                            </small>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $expenses->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>

<!-- Initialize Tooltips -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>

@endsection
