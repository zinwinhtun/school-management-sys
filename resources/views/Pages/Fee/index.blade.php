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
                <a href="{{ route('fees.create') }}" class="btn btn-primary d-flex align-items-center fw-semibold">
                    <i class="bi bi-plus-circle me-2"></i> Add New Fee
                </a>
            </div>

        </div>
    </div>


    <!-- Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-0 py-3">
            <div class="row align-items-center g-3">

                <!-- Left side -->
                <div class="col-12 col-md-7 col-lg-8">
                    <span class="fw-semibold text-muted">Unpaid Fees – </span>
                    <span class="fw-bold text-primary">{{ $fees->total() }}</span>
                </div>

                <!-- Right side (Search) -->
                <div class="col-12 col-md-5 col-lg-4">
                    <form action="{{ route('fees.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text"
                                class="form-control rounded-start-pill"
                                placeholder="Search student name..."
                                name="query"
                                value="{{ request('query') }}">
                            <button class="btn btn-primary rounded-end-pill px-3" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
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
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($fees as $fee)
                        <tr>
                            <td>{{ ($fees->currentPage() - 1) * $fees->perPage() + $loop->iteration }}</td>

                            <td class="text-start">
                                {{ $fee->student->name ?? '-' }}<br>
                                <small class="text-muted">{{ $fee->student->phone ?? '' }}</small>
                            </td>

                            <td>
                                <span class="badge bg-info">{{ $fee->class->name ?? 'N/A' }}</span>
                            </td>

                            <td>
                                <span class="fw-bold text-primary">{{ number_format($fee->total_amount) }} KS</span>
                            </td>

                            <td>
                                <span class="fw-bold text-success">{{ number_format($fee->paid_amount) }} KS</span>
                            </td>

                            <td>
                                <span class="badge bg-danger rounded-pill px-3">Unpaid</span>
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-1 flex-wrap">

                                    <!-- Edit -->
                                    <a href="#"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <!-- Delete -->
                                    <button class="btn btn-outline-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteFee{{ $fee->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteFee{{ $fee->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow rounded-4">

                                                <div class="modal-header bg-danger text-white rounded-top-4">
                                                    <h5 class="modal-title d-flex align-items-center">
                                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                                        Confirm Delete
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body text-center py-4">
                                                    <p class="fs-5 mb-3">Are you sure you want to delete this fee?</p>
                                                    <h6 class="text-danger fw-bold mb-0">
                                                        {{ $fee->student->name ?? '' }}
                                                    </h6>
                                                </div>

                                                <div class="modal-footer border-0 justify-content-center pb-4">
                                                    <button type="button"
                                                        class="btn btn-outline-secondary px-4 rounded-3"
                                                        data-bs-dismiss="modal">
                                                        <i class="bi bi-x-circle me-1"></i> Cancel
                                                    </button>

                                                    <form action="#" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger px-4 rounded-3">
                                                            <i class="bi bi-trash-fill me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-cash-stack display-4 text-muted d-block mb-3"></i>
                                <h5 class="text-muted">No unpaid fees</h5>

                                <a href="{{ route('fees.create') }}"
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
