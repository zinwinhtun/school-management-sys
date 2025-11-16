@extends('layouts.app')

@section('content')

<div class="container py-4">

    <h3 class="fw-bold mb-4">
        <i class="bi bi-cash-stack"></i> Income & Expense Report
    </h3>

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
            <button class="btn btn-success w-100">
                <i class="bi bi-filter"></i> Filter
            </button>
        </div>
    </form>

    <div class="card shadow-sm rounded-4">
        <div class="card-body p-0">

            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Account</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Net Income</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($accounts as $acc)
                    @php
                        $row = $data->firstWhere('name', $acc->name);
                    @endphp

                    <tr>
                        <td>{{ $row['name'] }}</td>
                        <td>{{ number_format($row['debit'], 2) }}</td>
                        <td>{{ number_format($row['credit'], 2) }}</td>
                        <td>{{ number_format($row['net'], 2) }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>

    <div class="mt-3">
        {{ $accounts->withQueryString()->links() }}
    </div>

</div>

@endsection
