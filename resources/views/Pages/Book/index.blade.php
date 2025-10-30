@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="container-fluid mb-4 px-3">
        <div class="row align-items-center gy-2">

            <div class="col-12 col-md-8 text-center text-md-start">
                <h2 class="fw-bold text-primary mb-0">
                    <i class="bi bi-book-half me-2"></i> Books List
                </h2>
            </div>

            <div class="col-12 col-md-4 d-flex flex-wrap justify-content-center justify-content-md-end gap-2">
                {{-- Add New Book --}}
                <button type="button" class="btn btn-primary d-flex align-items-center"
                    data-bs-toggle="modal" data-bs-target="#createBookModal">
                    <i class="bi bi-plus-circle me-2"></i> Add New Book
                </button>

                {{-- Sell Book --}}
                <a href="{{ route('books.sellForm') }}" class="btn btn-primary d-flex align-items-center fw-semibold">
                    <i class="bi bi-cart4 me-2"></i> Sell Book
                </a>

                {{-- Sell History --}}
                <a href="{{ route('books.sellHistory') }}" class="btn btn-primary d-flex align-items-center fw-semibold">
                    <i class="bi bi-clock-history me-2"></i> Sell History
                </a>
            </div>

        </div>
    </div>

    <!-- Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-0 py-3">
            <div class="row align-items-center g-3">
                <!-- Left side -->
                <div class="col-12 col-md-7 col-lg-8">
                    <span class="fw-semibold text-muted">Total Books – </span>
                    <span class="fw-bold text-primary">{{ $books->total() }}</span>
                </div>

                <!-- Right side (Search) -->
                <div class="col-12 col-md-5 col-lg-4">
                    <form action="{{ route('books.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text"
                                class="form-control rounded-start-pill"
                                placeholder="Search books..."
                                name="query"
                                value="{{ request('query') }}">
                            <button class="btn btn-primary rounded-end-pill px-3" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Table -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th class="text-start">Name</th>
                            <th>Category</th>
                            <th>Class</th>
                            <th>Stock</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                        <tr>
                            <td>{{ ($books->currentPage() - 1) * $books->perPage() + $loop->iteration }}</td>
                            <td class="text-start">{{ $book->name }}</td>
                            <td>{{ $book->category ?? '-' }}</td>
                            <td><span class="badge bg-info">{{ $book->classType->name ?? 'N/A' }}</span></td>
                            <td>
                                <span class="badge bg-{{ $book->stock > 7 ? 'success' : 'danger' }}">
                                    {{ $book->stock }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1 flex-wrap">
                                    <!-- Edit Button -->
                                    <a href="{{route('books.edit', $book->id)}}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- Delete Button -->
                                    <button class="btn btn-outline-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteBookModal{{ $book->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteBookModal{{ $book->id }}" tabindex="-1"
                                        aria-labelledby="deleteBookModalLabel{{ $book->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow rounded-4">
                                                <div class="modal-header bg-danger text-white rounded-top-4">
                                                    <h5 class="modal-title d-flex align-items-center" id="deleteBookModalLabel{{ $book->id }}">
                                                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Delete
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body text-center py-4">
                                                    <p class="fs-5 mb-3">Are you sure you want to delete this book?</p>
                                                    <h6 class="text-danger fw-bold mb-0">{{ $book->name }}</h6>
                                                </div>

                                                <div class="modal-footer border-0 justify-content-center pb-4">
                                                    <button type="button" class="btn btn-outline-secondary px-4 rounded-3" data-bs-dismiss="modal">
                                                        <i class="bi bi-x-circle me-1"></i> Cancel
                                                    </button>
                                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger px-4 rounded-3">
                                                            <i class="bi bi-trash-fill me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-book display-4 text-muted d-block mb-3"></i>
                                <h5 class="text-muted">No books available</h5>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createBookModal">
                                    <i class="bi bi-plus-circle me-2"></i>Add First Book
                                </button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($books->hasPages())
            <div class="card-footer bg-transparent border-0 py-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                    <small class="text-muted">
                        Showing <strong>{{ $books->firstItem() }}</strong> to
                        <strong>{{ $books->lastItem() }}</strong> of
                        <strong>{{ $books->total() }}</strong> results
                    </small>
                    {{ $books->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>

</div>
@include('Pages.Book.create');
@endsection