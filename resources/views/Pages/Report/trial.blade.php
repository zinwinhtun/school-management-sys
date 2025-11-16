@extends('layouts.app')

@section('content')

<div class="container py-4">

    <h3 class="fw-bold mb-4">
        <i class="bi bi-balance-scale"></i> Trial Balance
    </h3>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">

            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Account</th>
                        <th>Debit</th>
                        <th>Credit</th>
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
