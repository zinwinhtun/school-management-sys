<?php

namespace App\Http\Repository;

use Exception;
use App\Models\Account;
use App\Models\Expenses;
use App\Models\JournalEntry;
use App\Models\JournalPosting;
use Illuminate\Support\Facades\DB;

class ExpenseRepository
{

    protected $model;

    public function __construct(Expenses $model)
    {
        $this->model = $model;
    }

    public function all($search = null)
    {
        $query = $this->model::with('user')->latest();

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        return $query->paginate(10);
    }


    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $expenses =  $this->model::create($data);
            //Accounting Logic 
            $asset_account = Account::where('code', '1001')->first();
            $expenses_account = Account::where('code', '5002')->first();

            $journalEntry = JournalEntry::create([
                'date' => now(),
                'description' => "Expense added for : $expenses->title",
                'reference_id' => $expenses->id,
                'reference_type' => Expenses::class,
            ]);

            // Debit Expenses
            JournalPosting::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $expenses_account->id,
                'debit' =>  $expenses->amount,
                'credit' => 0,
            ]);

            // Credit Asset
            JournalPosting::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $asset_account->id,
                'debit' => 0,
                'credit' => $expenses->amount,
            ]);

            DB::commit();
            return $expenses;
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('expenses.index')->with('error', $e->getMessage());
        }
    }

    public function update(array $data, string $id)
    {
        DB::beginTransaction();

        try {
            $expense = $this->model::findOrFail($id);
            $oldAmount = $expense->amount;

            // Update expense
            $expense->update($data);

            $asset_account = Account::where('code', '1001')->first();
            $expenses_account = Account::where('code', '5002')->first();

            // Find existing journal entry
            $journalEntry = JournalEntry::where('reference_id', $expense->id)->where('reference_type', Expenses::class)->first();

            if ($journalEntry) {
                // Update description if needed
                $journalEntry->update([
                    'description' => "Expense added for : $expense->title",
                ]);

                // Update journal postings
                $debitPosting = JournalPosting::where('journal_entry_id', $journalEntry->id)->where('account_id', $expenses_account->id)->first();

                $creditPosting = JournalPosting::where('journal_entry_id', $journalEntry->id)->where('account_id', $asset_account->id)->first();

                if ($debitPosting && $creditPosting) {
                    $debitPosting->update(['debit' => $expense->amount]);
                    $creditPosting->update(['credit' => $expense->amount]);
                }
            }

            DB::commit();
            return $expense;
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('expenses.index')->with('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            return $this->model::whereId($id)->delete();
        } catch (\Exception $e) {
            return redirect()->route('expenses.index')->with('error', $e->getMessage());
        }
    }
}
