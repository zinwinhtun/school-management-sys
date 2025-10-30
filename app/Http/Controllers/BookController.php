<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Student;
use App\Models\BookSell;
use App\Models\ClassType;
use Illuminate\Http\Request;
use App\Http\Requests\Book\CreateRequest;
use App\Http\Requests\Book\UpdateRequest;

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

    public function update(UpdateRequest $request, $id)
    {
        try {
            $validated = $request->validated();

            $this->bookRepository->update($id, $validated);

            return redirect()->route('books.index')->with('success', 'Book updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage(), 'edit_' . $id)->withInput()->with('edit_modal_id', $id);
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

    public function sellForm()
    {
        $books = Book::all();
        $students = Student::all();
        return view('Pages.Book.sell', compact('books', 'students'));
    }

    public function addToSession(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'book_id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        //book stock check
        $book = Book::findOrFail($request->book_id);

        if ($book->stock <= $request->quantity) {
            return redirect()->route('books.sellForm')->with('error', 'Insufficient stock for the selected book.');
        }

        $this->bookRepository->addToSession($request);
        return redirect()->route('books.sellForm')->with('success', 'Book added to cart!');
    }

    public function sell(Request $request)
    {
        $this->bookRepository->saveToDatabase();
        return redirect()->route('books.index')->with('success', 'Books sold successfully!');
    }

    public function removeFromSession($index)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$index])) {
            unset($cart[$index]);
            session()->put('cart', array_values($cart));
        }
        return redirect()->route('books.sellForm')->with('success', 'Item removed from cart successfully!');
    }

    public function clearCart()
    {
        session()->forget(['cart', 'student_id']);
        return redirect()->route('books.sellForm')->with('success', 'Cart cleared successfully!');
    }

    public function sellHistory()
    {
        // Eager load student and book to avoid N+1 problem
        $sells = \App\Models\BookSell::with(['student', 'book'])
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Pagination 10 per page

        return view('Pages.Book.history', compact('sells'));
    }
}
