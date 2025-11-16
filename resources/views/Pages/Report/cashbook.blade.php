@extends('layouts.app')

@section('content')

<div class="container py-4">

    <h3 class="fw-bold mb-4">
        <i class="bi bi-journal-text"></i> Cashbook Report
    </h3>

    <!-- Filter -->
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label class="form-label">From</label>
            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">To</label>
            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100">
                <i class="bi bi-filter"></i> Filter
            </button>
        </div>
    </form>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">

            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Debit (In)</th>
                        <th>Credit (Out)</th>
                        <th>Balance</th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="fw-bold table-secondary">
                        <td colspan="4">Opening Balance</td>
                        <td>{{ number_format($opening,2) }}</td>
                    </tr>

                    @foreach ($postings as $post)
                    <tr>
                        <td>{{ $post->journalEntry->date->format('d-m-Y') }}</td>
                        <td>{{ $post->journalEntry->description }}</td>
                        <td>{{ number_format($post->debit,2) }}</td>
                        <td>{{ number_format($post->credit,2) }}</td>
                        <td>{{ number_format($post->running_balance,2) }}</td>
                    </tr>
                    @endforeach

                    <tr class="fw-bold table-secondary">
                        <td colspan="4">Closing Balance</td>
                        <td>{{ number_format($closing,2) }}</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>

    <div class="mt-3">
        {{ $postings->withQueryString()->links() }}
    </div>

</div>

@endsection
