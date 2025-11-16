<?php

namespace App\Http\Repository;

use App\Models\Fees;
use App\Models\Account;
use App\Models\FeeHistory;
use App\Models\JournalEntry;
use App\Models\JournalPosting;
use Illuminate\Support\Facades\DB;

class FeeRepository
{
    protected $model;
    protected $feeHistory;

    public function __construct(Fees $model, FeeHistory $feeHistory)
    {
        $this->model = $model;
        $this->feeHistory = $feeHistory;
    }

    public function collect(array $data)
    {
        $data['full_paid'] = ($data['total_amount'] == $data['amount']);
        $data['paid_amount'] =  $data['amount'];

        DB::beginTransaction();

        try {

            $fee = $this->model::create($data);

            $this->feeHistory::create([
                'fee_id' => $fee->id,
                'amount' => $data['amount'],
                'type' => 'collect',
                'note' => $data['note']
            ]);

            //Accounting Logic 
            $asset_account = Account::where('code', '1001')->first();
            $revenue_account = Account::where('code', '4001')->first();

            $journalEntry = JournalEntry::create([
                'date' => now(),
                'description' => "Fee collected from student ID: $fee->student_id",
                'reference_id' => $fee->id,
                'reference_type' => Fees::class,
            ]);

            // Debit Asset
            JournalPosting::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $asset_account->id,
                'debit' =>  $data['amount'],
                'credit' => 0,
            ]);

            // Credit Revenue
            JournalPosting::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $revenue_account->id,
                'debit' => 0,
                'credit' => $data['amount'],
            ]);

            DB::commit();
            return $fee;
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            throw $e;
        }
    }

    public function addCollect(int $id, array $data)
    {
        try {
            DB::beginTransaction();

            $fee = $this->model::with('student')->findOrFail($id);
            $newPaid = $fee->paid_amount + $data['amount'];

            $isFullPaid = $newPaid >= $fee->total_amount ? 1 : 0;

            $fee->update([
                'paid_amount' => $newPaid,
                'full_paid'   => $isFullPaid,
            ]);

            if ($newPaid > $fee->total_amount) {
                throw new \Exception("Paid amount cannot exceed total amount.");
            }

            $newCollect = $this->feeHistory::create([
                'fee_id' => $fee->id,
                'amount' => $data['amount'],
                'type' => 'collect',
                'note' => $data['note']
            ]);

            //Accounting Logic 
            $asset_account = Account::where('code', '1001')->first();
            $revenue_account = Account::where('code', '4001')->first();

            $journalEntry = JournalEntry::create([
                'date' => now(),
                'description' => "Fee collected from student ID: $fee->student_id",
                'reference_id' => $fee->id,
                'reference_type' => Fees::class,
            ]);

            // Debit Asset
            JournalPosting::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $asset_account->id,
                'debit' =>  $data['amount'],
                'credit' => 0,
            ]);

            // Credit Revenue
            JournalPosting::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $revenue_account->id,
                'debit' => 0,
                'credit' => $data['amount'],
            ]);

            DB::commit();
            return $newCollect;
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            throw $e;
        }
    }

    public function addRefund(int $id, array $data)
    {
        try {
            DB::beginTransaction();

            $fee = $this->model::findOrFail($id);
            $newPaid = $fee->paid_amount - $data['amount'];
            $isFullPaid = $newPaid >= $fee->total_amount ? 1 : 0;

            $fee->update([
                'paid_amount' => $newPaid,
                'full_paid'   => $isFullPaid,
            ]);

            if ($data['amount'] > $fee->total_amount) {
                throw new \Exception("Paid amount cannot exceed total amount.");
            }

            $newCollect = $this->feeHistory::create([
                'fee_id' => $fee->id,
                'amount' => $data['amount'],
                'type' => 'refund',
                'note' => $data['note']
            ]);

            //Accounting Logic 
            $asset_account = Account::where('code', '1001')->first();
            $liability_account = Account::where('code', '2002')->first();

            $journalEntry = JournalEntry::create([
                'date' => now(),
                'description' => "Fee refunded from student ID: $fee->student_id",
                'reference_id' => $fee->id,
                'reference_type' => Fees::class,
            ]);

            // Debit Liability
            JournalPosting::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $liability_account->id,
                'debit' =>  $data['amount'],
                'credit' => 0,
            ]);

            // Credit Asset
            JournalPosting::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $asset_account->id,
                'debit' => 0,
                'credit' => $data['amount'],
            ]);

            DB::commit();
            return $newCollect;
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            throw $e;
        }
    }
}
