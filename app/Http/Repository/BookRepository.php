<?php

namespace App\Http\Repository;

use App\Models\Book;
use App\Models\BookSell;
use Illuminate\Support\Facades\Session;

class BookRepository
{
    protected $model;

    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    public function getAll($query = null, $perPage = 5)
    {
        $booksQuery = $this->model->with('classType');

        if ($query) {
            $booksQuery->where('name', 'like', '%' . $query . '%')
                ->orWhere('category', 'like', '%' . $query . '%')
                ->orWhereHas('classType', function ($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%');
                });
        }

        return $booksQuery->orderBy('id', 'desc')->paginate($perPage);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        try {
            $book = $this->model->findOrFail($id);
            $book->update($data);
            return $book;
        } catch (\Exception $e) {
            logger()->error("Failed to update book with ID {$id}: " . $e->getMessage());
            throw new \Exception("Book not found or update failed.");
        }
    }

    public function addToSession($request)
    {
        $book = $this->model::findOrFail($request->book_id);
        $studentId = $request->student_id;
        $qty = (int) $request->quantity;

        $cart = Session::get('cart', []);
        $found = false;

        foreach ($cart as &$item) {
            if ($item['book_id'] == $book->id) {
                $item['quantity'] += $qty;
                $item['total_price'] = $item['quantity'] * $book->sell_price;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = [
                'book_id'     => $book->id,
                'book_title'  => $book->name,
                'price'       => $book->sell_price,
                'quantity'    => $qty,
                'total_price' => $book->sell_price * $qty,
            ];
        }

        Session::put('cart', $cart);
        Session::put('student_id', $studentId);
    }

    public function saveToDatabase()
    {
        $cart = Session::get('cart', []);
        $studentId = Session::get('student_id');
        // dd($cart);
        if (!empty($cart)) {
            foreach ($cart as $item) {
                BookSell::create([
                    'book_id'     => $item['book_id'],
                    'student_id'  => $studentId,
                    'quantity'    => $item['quantity'],
                    'total_price' => $item['total_price'],
                ]);

                // Reduce stock
                $book = Book::find($item['book_id']);
                if ($book) {
                    $book->stock -= $item['quantity'];
                    $book->save();
                }
            }
        }

        Session::forget(['cart', 'student_id']);
    }
}
