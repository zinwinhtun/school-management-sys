<?php

namespace App\Http\Repository;

use App\Models\Book;
use App\Models\Account;
use App\Models\BookSell;
use App\Models\JournalEntry;
use App\Models\JournalPosting;
use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();
        try {
            $book = $this->model->create($data);

            //Accounting Logic 
            $asset_account = Account::where('code', '1001')->first();
            $book_purchase_account = Account::where('code', '5003')->first();

            $journalEntry = JournalEntry::create([
                'date' => now(),
                'description' => "Book Purchased with Book ID: $book->id",
                'reference_id' => $book->id,
                'reference_type' => Book::class,
            ]);

            // Debit Asset
            JournalPosting::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $book_purchase_account->id,
                'debit' =>  $book->purchase_price,
                'credit' => 0,
            ]);

            // Credit Expenses
            JournalPosting::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $asset_account->id,
                'debit' => 0,
                'credit' => $book->purchase_price,
            ]);

            DB::commit();
            return $book;
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error("Failed to create book : " . $e->getMessage());
            throw new \Exception("Book not found or create failed.");
        }
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();

        try {
            $book = $this->model->findOrFail($id);

            // Save old values in case needed
            $oldAmount = $book->purchase_price;

            // Update book
            $book->update($data);

            // Find the related journal entry
            $journalEntry = JournalEntry::where('reference_id', $book->id)->where('reference_type', Book::class)->first();

            if ($journalEntry) {

                // Get accounts
                $asset_account = Account::where('code', '1001')->first();
                $book_purchase_account = Account::where('code', '5003')->first();

                // Update debit posting (Book Purchase Account)
                $debitPosting = JournalPosting::where('journal_entry_id', $journalEntry->id)->where('account_id', $book_purchase_account->id)->first();

                // Update credit posting (Asset Account)
                $creditPosting = JournalPosting::where('journal_entry_id', $journalEntry->id)->where('account_id', $asset_account->id)->first();

                if ($debitPosting && $creditPosting) {
                    $debitPosting->update(['debit' => $book->purchase_price]);
                    $creditPosting->update(['credit' => $book->purchase_price]);
                }
            }

            DB::commit();
            return $book;
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error("Failed to update book with ID {$id}: " . $e->getMessage());
            throw new \Exception("Book update failed.");
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

    public function sell()
    {
        DB::beginTransaction();
        try {
            $cart = Session::get('cart', []);
            $studentId = Session::get('student_id');

            if (!empty($cart)) {
                foreach ($cart as $item) {
                    $bookSellHistory = BookSell::create([
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

                    //Accounting Logic 
                    $asset_account = Account::where('code', '1001')->first();
                    $revenue_account = Account::where('code', '4002')->first();

                    $journalEntry = JournalEntry::create([
                        'date' => now(),
                        'description' => "Book sales for Student ID : $studentId",
                        'reference_id' => $bookSellHistory->id,
                        'reference_type' => BookSell::class,
                    ]);

                    // Debit Asset
                    JournalPosting::create([
                        'journal_entry_id' => $journalEntry->id,
                        'account_id' => $asset_account->id,
                        'debit' => $item['total_price'],
                        'credit' => 0,
                    ]);

                    // Credit Revenue
                    JournalPosting::create([
                        'journal_entry_id' => $journalEntry->id,
                        'account_id' => $revenue_account->id,
                        'debit' => 0,
                        'credit' => $item['total_price'],
                    ]);
                }
            }

            Session::forget(['cart', 'student_id']);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error("Failed to sell book : " . $e->getMessage());
            throw new \Exception("Book sell failed.");
        }
    }
}
