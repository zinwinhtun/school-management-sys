@extends('layouts.app')

@section('content')
<div class="container py-4 d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card shadow-lg rounded-5 p-4 p-md-5 text-center"
        style="max-width: 500px; width: 100%; backdrop-filter: blur(10px); background: rgba(255,255,255,0.85); border: 1px solid rgba(0,0,0,0.05);">

        <div class="mb-4">
            <div class="d-inline-flex align-items-center justify-content-center bg-danger rounded-circle shadow" style="width: 80px; height: 80px;">
                <i class="bi bi-ban fs-1 text-white"></i>
            </div>
        </div>

        <h1 class="h2 fw-bold mb-2">403 — Access Denied</h1>
        <p class="text-muted mb-4">You don’t have permission to access this page.</p>

        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mb-3">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg d-flex align-items-center gap-2">
                <i class="bi bi-arrow-left-circle"></i> Back
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-primary btn-lg d-flex align-items-center gap-2">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>

        <small class="d-block text-muted">If you think this is an error, contact your administrator.</small>
    </div>
</div>

<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }

    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }

    .btn-outline-secondary:hover {
        background-color: rgba(108, 117, 125, 0.1);
    }
</style>
@endsection