@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center">
    <div class="card shadow-lg rounded-4" style="max-width: 540px; width: 100%;">
        <div class="card-body text-center p-4 p-md-5">
            <div class="mb-3">
                <span class="d-inline-block bg-danger rounded-circle p-3 text-white shadow-sm" style="line-height:0;">
                    <i class="bi bi-ban fs-1"></i>
                </span>
            </div>

            <h1 class="h2 fw-bold mb-2">403 — Access denied</h1>
            <p class="lead text-muted mb-4">
                You don’t have permission to access this page.
            </p>

            <div class="d-flex gap-2 justify-content-center flex-column flex-sm-row">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4 py-2">
                    <i class="bi bi-arrow-left-circle me-2"></i>Back
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </button>
                </form>
            </div>

            <small class="d-block text-muted mt-3">
                If you think this is an error, contact your administrator.
            </small>
        </div>
    </div>
</div>
@endsection
