@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-indigo text-white rounded-top-4">
            <h4 class="mb-0">Add Collect</h4>
        </div>

        <div class="card-body">

            <h5 class="fw-bold mb-3">{{ $fee->student->name }} | {{$fee->class->name}}</h5> 
            <p>Title - <span>{{$fee->title}}</span></p>

            <form action="{{ route('fees.collect.store', $fee->id) }}" method="POST" class="row gy-3">
                @csrf

                <!-- Amount -->
                <div class="col-12">
                    <label class="form-label fw-semibold">Amount</label>
                    <input
                        type="number"
                        name="amount"
                        class="form-control @error('amount') is-invalid @enderror"
                        value="{{ old('amount') }}">

                    @error('amount')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Note -->
                <div class="col-12">
                    <label class="form-label fw-semibold">Note (optional)</label>
                    <textarea
                        name="note"
                        class="form-control @error('note') is-invalid @enderror"
                        rows="2">{{ old('note') }}</textarea>

                    @error('note')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="col-12 d-flex justify-content-between mt-3">
                    <a href="{{ route('fees.index') }}" class="btn btn-secondary px-4">Back</a>

                    <button type="submit" class="btn btn-primary px-4 d-flex align-items-center gap-1">
                        <i class="bi bi-cash-coin"></i>
                        Add Collect
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection