<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\CreateRequest;
use App\Http\Requests\Book\UpdateRequest;
use App\Models\Book;
use App\Models\ClassType;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookRepository;

    public function __construct(\App\Http\Repository\BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function index(Request $request)
    {
        $query = $request->input('query');
        $classes = ClassType::get();
        $books = $this->bookRepository->getAll($query);

        return view('Pages.Book.index', compact('books', 'classes'));
    }

    public function store(CreateRequest $request)
    {
        try {
            $validated = $request->validated();

            $this->bookRepository->create($validated);

            return redirect()->route('books.index')->with('success', 'Book created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('books.index')->with('error', 'An error occurred while creating the book: ' . $e->getMessage());
        }
    }

    // Edit function to show the edit form
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $classes = ClassType::all();

        return view('Pages.Book.edit', compact('book', 'classes'));
    }

    public function update(UpdateRequest $request, $id )
    {
        try {
            $validated = $request->validated();

            $this->bookRepository->update($id, $validated);

            return redirect()->route('books.index')->with('success', 'Book updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage(),'edit_' . $id)->withInput()->with('edit_modal_id', $id);
        }
    }

    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();

            return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('books.index')->with('error', 'An error occurred while deleting the book: ' . $e->getMessage());
        }
    }
}
