@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- All History Table (Paginated) -->
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-indigo text-white rounded-top-4 px-4 py-3">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">

                <!-- Title -->
                <div>
                    <h4 class="mb-0 fw-bold">
                        Collect & Refund History
                    </h4>

                    <!-- Sub Info -->
                    <small class="opacity-75">
                        {{ $fee->student->name }} —
                        {{ $fee->class->name }}
                    </small>
                </div>

                <!-- Back -->
                <a href="{{ route('fees.index') }}"
                    class="btn btn-light text-indigo fw-semibold px-4 shadow-sm d-flex align-items-center gap-2">
                    <i class="bi bi-arrow-left"></i>
                    Back
                </a>
            </div>

        </div>



        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($history as $h)
                    <tr>
                        <td>{{ ($history->currentPage() - 1) * $history->perPage() + $loop->iteration }}</td>

                        <td>{{ $fee->title }}</td>

                        <td class="fw-bold {{ $h->type == 'refund' ? 'text-danger' : 'text-muted' }}">
                            {{ $h->type == 'refund' ? '-' : '' }}{{ number_format($h->amount) }} MMK
                        </td>

                        <td>
                            @if($h->type == 'collect')
                            <span class="badge bg-success px-3">Collect</span>
                            @else
                            <span class="badge bg-danger px-3">Refund</span>
                            @endif
                        </td>

                        <td>{{ $h->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($h->note)
                            <span class="text-muted  fw-semibold" title="{{ $h->note }}" style="unicode-bidi: bidi-override; direction: ltr;">
                                {{ Str::limit($h->note, 20) }}
                                <i class="bi bi-info-circle"></i>
                            </span>
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">No history found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3">
            {{ $history->links() }}
        </div>
    </div>

</div>
@endsection