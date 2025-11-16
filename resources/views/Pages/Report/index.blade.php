@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h3 class="mb-4 fw-bold">
        <i class="bi bi-file-earmark-bar-graph"></i> Reports
    </h3>

    <div class="row g-4">

        <!-- Cashbook -->
        <div class="col-md-4">
            <a href="{{ route('reports.cashbook') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 hover shadow-lg p-4 rounded-4 text-center">
                    <i class="bi bi-journal-text fs-1 text-primary"></i>
                    <h5 class="mt-3 fw-bold">Cashbook Report</h5>
                </div>
            </a>
        </div>

        <!-- Income -->
        <div class="col-md-4">
            <a href="{{ route('reports.income') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 hover shadow-lg p-4 rounded-4 text-center">
                    <i class="bi bi-cash-stack fs-1 text-success"></i>
                    <h5 class="mt-3 fw-bold">Income & Expense Report</h5>
                </div>
            </a>
        </div>

        <!-- Trial Balance -->
        <div class="col-md-4">
            <a href="{{ route('reports.trial') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 hover shadow-lg p-4 rounded-4 text-center">
                    <i class="bi bi-sliders2-vertical fs-1 text-danger"></i>
                    <h5 class="mt-3 fw-bold">Trial Balance</h5>
                </div>
            </a>
        </div>

    </div>
</div>
@endsection
