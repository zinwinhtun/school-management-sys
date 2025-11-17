@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Overview Cards -->
    <div class="row g-4 mb-4">

        <!-- Total Students -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-indigo text-white bg-opacity-10 p-3 rounded">
                        <i class="bi bi-people-fill text-indigo fs-4"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-1">Total Students</h6>
                        <p class="fw-bold text-indigo mb-1">{{ $totalStudents }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fee Collection -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded">
                        <i class="bi bi-cash-coin text-success fs-4"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-1">Fee Collection</h6>
                        <p class="fw-bold text-success mb-1">{{ number_format($feeThisMonth) }} MMK</p>
                        <small class="text-muted">This month</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Book Revenue -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded">
                        <i class="bi bi-journal-text text-primary fs-4"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-1">Book Revenue</h6>
                        <p class="fw-bold text-primary mb-1">{{ number_format($bookRevenueThisMonth) }} MMK</p>
                        <small class="text-muted">This month</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Expenses -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-danger bg-opacity-10 p-3 rounded">
                        <i class="bi bi-graph-down text-danger fs-4"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-1">Total Expenses</h6>
                        <p class="fw-bold text-danger mb-1">{{ number_format($totalExpensesThisMonth) }} MMK</p>
                        <small class="text-muted">This month</small>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Reports Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0"><i class="bi bi-bar-chart-line me-2 text-indigo"></i>Reports Summary</h5>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <!-- Fee Chart -->
                <div class="col-12 col-md-6">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-muted mb-0">Fee Collection Trend </h6>
                    </div>
                    <canvas id="feeCollectionChart" class="chart"></canvas>
                </div>

                <!-- Class Overview -->
                <div class="col-12 col-md-6">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-muted mb-0">Class Overview</h6>
                    </div>
                    <canvas id="classOverviewChart" class="chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-lightning me-2 text-warning"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6 col-sm-4 col-md-2">
                            <a href="{{route('student.create')}}" class="btn btn-outline-primary w-100 h-100 py-3 d-flex flex-column align-items-center">
                                <i class="bi bi-person-plus fs-4 mb-2"></i>
                                <small>Add Student</small>
                            </a>
                        </div>
                        <div class="col-6 col-sm-4 col-md-2">
                            <a href="{{route('collect.create')}}" class="btn btn-outline-success w-100 h-100 py-3 d-flex flex-column align-items-center">
                                <i class="bi bi-cash-coin fs-4 mb-2"></i>
                                <small>Fee</small>
                            </a>
                        </div>
                        <div class="col-6 col-sm-4 col-md-2">
                            <a href="{{route('books.sellForm')}}" class="btn btn-outline-info w-100 h-100 py-3 d-flex flex-column align-items-center">
                                <i class="bi bi-cart-plus fs-4 mb-2"></i>
                                <small>Sell Book</small>
                            </a>
                        </div>
                        <div class="col-6 col-sm-4 col-md-2">
                            <a href="{{route('expenses.create')}}" class="btn btn-outline-warning w-100 h-100 py-3 d-flex flex-column align-items-center">
                                <i class="bi bi-receipt fs-4 mb-2"></i>
                                <small>Add Expenses</small>
                            </a>
                        </div>
                        <div class="col-6 col-sm-4 col-md-2">
                            <a href="{{route('reports.index')}}" class="btn btn-outline-danger w-100 h-100 py-3 d-flex flex-column align-items-center">
                                <i class="bi bi-file-text fs-4 mb-2"></i>
                                <small>See Reports</small>
                            </a>
                        </div>
                        <div class="col-6 col-sm-4 col-md-2">
                            <a href="{{route('profile.show')}}" class="btn btn-outline-secondary w-100 h-100 py-3 d-flex flex-column align-items-center">
                                <i class="bi bi-gear fs-4 mb-2"></i>
                                <small>Settings</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .chart-placeholder {
        height: 200px;
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
    }

    .card {
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .btn-outline-primary,
    .btn-outline-success,
    .btn-outline-info,
    .btn-outline-warning,
    .btn-outline-danger,
    .btn-outline-secondary {
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover,
    .btn-outline-success:hover,
    .btn-outline-info:hover,
    .btn-outline-warning:hover,
    .btn-outline-danger:hover,
    .btn-outline-secondary:hover {
        transform: translateY(-1px);
    }

    canvas.chart {
        height: 250px !important;
        /* fixed height */
        max-height: 300px;
        /* optional */
        width: 100% !important;
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fee Chart
        const feeCtx = document.getElementById('feeCollectionChart');
        if (feeCtx) {
            new Chart(feeCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: @json($feeLabels),
                    datasets: [{
                        label: "Fee Collected",
                        data: @json($feeTrend),
                        backgroundColor: "#0d6efd",
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        }

        // Class Chart
        const classCtx = document.getElementById('classOverviewChart');
        if (classCtx) {
            new Chart(classCtx.getContext('2d'), {
                type: 'pie',
                data: {
                    labels: @json($classes),
                    datasets: [{
                        data: @json($studentCounts),
                        backgroundColor: [
                            "#0d6efd", "#6610f2", "#198754",
                            "#dc3545", "#fd7e14", "#20c997"
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        }

        // Filter handlers
        document.getElementById('feeFilter').addEventListener('change', function() {
            window.location.href = `?fee_range=${this.value}`;
        });
        document.getElementById('classFilter').addEventListener('change', function() {
            window.location.href = `?class_range=${this.value}`;
        });
    });
</script>

@endsection