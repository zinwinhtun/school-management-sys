@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Overview Cards -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-indigo text-white bg-opacity-10 p-3 rounded">
                                <i class="bi bi-people-fill text-indigo fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Total Students</h6>
                            <h3 class="card-title text-indigo mb-1">1,240</h3>
                            <small class="text-muted">
                                <span class="text-success">Active: 1,200</span> |
                                <span class="text-danger">Inactive: 40</span>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="bi bi-cash-coin text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Monthly Fee Collection</h6>
                            <h3 class="card-title text-success mb-1">MMK 8.5M</h3>
                            <small class="text-success">
                                <i class="bi bi-arrow-up"></i> 5% from last month
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="bi bi-journal-text text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Book Stock</h6>
                            <h3 class="card-title text-primary mb-1">320</h3>
                            <small class="text-warning">
                                <i class="bi bi-exclamation-triangle"></i> 20 low-stock items
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-danger bg-opacity-10 p-3 rounded">
                                <i class="bi bi-graph-down text-danger fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Total Expenses</h6>
                            <h3 class="card-title text-danger mb-1">MMK 2.1M</h3>
                            <small class="text-muted">This month</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Section -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-bar-chart-line me-2 text-indigo"></i>
                        Reports Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 text-muted">Fee Collection Trend</h6>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        This Month
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">This Week</a></li>
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item" href="#">This Year</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="chart-placeholder bg-light rounded-3 p-4 d-flex align-items-center justify-content-center">
                                <div class="text-center text-muted">
                                    <i class="bi bi-bar-chart fs-1 d-block mb-2"></i>
                                    <span>Fee Collection Chart</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 text-muted">Expense Overview</h6>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        This Month
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">This Week</a></li>
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item" href="#">This Year</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="chart-placeholder bg-light rounded-3 p-4 d-flex align-items-center justify-content-center">
                                <div class="text-center text-muted">
                                    <i class="bi bi-pie-chart fs-1 d-block mb-2"></i>
                                    <span>Expense Distribution</span>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <a href="{{route('fees.create')}}" class="btn btn-outline-success w-100 h-100 py-3 d-flex flex-column align-items-center">
                                <i class="bi bi-cash-coin fs-4 mb-2"></i>
                                <small>Fee</small>
                            </a>
                        </div>
                        <div class="col-6 col-sm-4 col-md-2">
                            <a href="#" class="btn btn-outline-info w-100 h-100 py-3 d-flex flex-column align-items-center">
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
                            <a href="#" class="btn btn-outline-danger w-100 h-100 py-3 d-flex flex-column align-items-center">
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
</style>
@endsection