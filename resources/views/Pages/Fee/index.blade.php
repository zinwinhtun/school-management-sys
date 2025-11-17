@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="container-fluid mb-4 px-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">

            <!-- Left Title -->
            <div class="d-flex align-items-center justify-content-center justify-content-sm-start">
                <h2 class="fw-bold text-primary mb-0 d-flex align-items-center">
                    <i class="bi bi-cash-coin me-2"></i> Fees List
                </h2>
            </div>

            <!-- Right Buttons -->
            <div class="d-flex flex-wrap justify-content-center justify-content-md-end gap-2">
                <a href="{{ route('collect.create') }}" class="btn btn-primary d-flex align-items-center fw-semibold">
                    <i class="bi bi-plus-circle me-2"></i> Add New Fee
                </a>
            </div>

        </div>
    </div>

    <!-- Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-0 py-3">
            <form action="{{ route('fees.index') }}" method="GET">
                <div class="row align-items-center g-3">

                    <!-- Search -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="input-group">
                            <input type="text"
                                class="form-control rounded-start-pill"
                                placeholder="Search student name & class "
                                name="query"
                                value="{{ request('query') }}">
                            <button class="btn btn-primary rounded-end-pill px-3" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="col-12 col-md-4 col-lg-3">
                        <select name="status" class="form-select rounded-pill" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Full Paid</option>
                        </select>
                    </div>

                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th class="text-start">Student</th>
                            <th>Class</th>
                            <th>Title</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Payment Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($fees as $fee)
                        <tr>
                            <td>{{ ($fees->currentPage() - 1) * $fees->perPage() + $loop->iteration }}</td>

                            <td class="text-start">
                                {{ $fee->student->name ?? '-' }}<br>
                            </td>

                            <td>
                                <span class="badge bg-info">{{ $fee->class->name ?? 'N/A' }}</span>
                            </td>

                            <td>{{ $fee->title }}</td>

                            <td>
                                <span class="fw-bold text-primary">{{ number_format($fee->total_amount) }} MMK</span>
                            </td>

                            <td>
                                <span class="fw-bold text-success">{{ number_format($fee->paid_amount) }} MMK</span>
                            </td>

                            <td>
                                @if($fee->full_paid)
                                <span class="badge bg-success">Done</span>
                                @else
                                <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-1 flex-wrap">

                                    <a href="{{ route('fees.detail', $fee->id) }}"
                                        class="btn btn-outline-info btn-sm" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if(!$fee->full_paid)
                                        <a href="{{ route('fees.collect', $fee->id) }}"
                                            class="btn btn-outline-success btn-sm" title="Collect">
                                            <i class="bi bi-cash-coin"></i>
                                        </a>
                                    @endif

                                    <a href="{{route('refund.create', $fee->id)}}"
                                        class="btn btn-outline-primary btn-sm" title="Refund">
                                        <i class="bi bi-shuffle"></i>
                                    </a>

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-cash-stack display-4 text-muted d-block mb-3"></i>
                                <h5 class="text-muted">No fees found</h5>

                                <a href="{{ route('collect.create') }}"
                                    class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-circle me-2"></i> Add First Fee
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <!-- Pagination -->
            @if($fees->hasPages())
            <div class="card-footer bg-transparent border-0 py-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                    <small class="text-muted">
                        Showing <strong>{{ $fees->firstItem() }}</strong> to
                        <strong>{{ $fees->lastItem() }}</strong> of
                        <strong>{{ $fees->total() }}</strong> results
                    </small>
                    {{ $fees->appends(request()->query())->links() }}
                </div>
            </div>
            @endif

        </div>
    </div>

</div>

@endsection