<?php

namespace App\Http\Repository;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\JournalPosting;
use Illuminate\Support\Facades\DB;

class ReportRepository
{
    protected $cashAccount;
    public function __construct()
    {
        $this->cashAccount = Account::where('name', 'Glory')->first();
    }


    public function cashbook($from = null, $to = null, $perPage = 5)
    {
        $from = $from ? Carbon::parse($from)->startOfDay() : now()->startOfMonth();
        $to = $to ? Carbon::parse($to)->endOfDay() : now()->endOfMonth();

        $cashAccount = Account::where('name', 'Glory')->first();

        // Opening balance = previous to $from
        $opening = JournalPosting::join('journal_entries', 'journal_postings.journal_entry_id', '=', 'journal_entries.id')
            ->where('journal_postings.account_id', $cashAccount->id)
            ->where('journal_entries.date', '<', $from)
            ->sum(DB::raw('journal_postings.debit - journal_postings.credit'));

        // All postings for period (for total closing balance)
        $allPostings = JournalPosting::join('journal_entries', 'journal_postings.journal_entry_id', '=', 'journal_entries.id')
            ->where('journal_postings.account_id', $cashAccount->id)
            ->whereBetween('journal_entries.date', [$from, $to])
            ->orderByDesc('journal_entries.created_at')
            ->select('journal_postings.*')
            ->get();

        // Closing balance = opening + sum of all postings in period
        $closing = $opening + $allPostings->sum(fn($p) => $p->debit - $p->credit);

        // Paginate only for displaying table rows
        $query = JournalPosting::with('journalEntry')
            ->join('journal_entries', 'journal_postings.journal_entry_id', '=', 'journal_entries.id')
            ->where('journal_postings.account_id', $cashAccount->id)
            ->whereBetween('journal_entries.date', [$from, $to])
            ->orderByDesc('journal_entries.created_at') // ASC order
            ->select('journal_postings.*');

        $postings = $query->paginate($perPage)->appends(request()->query());

        // Running balance for paginated rows
        $balance = $opening;
        foreach ($postings as $post) {
            $balance += $post->debit - $post->credit;
            $post->running_balance = $balance;
        }

        // Last record (latest date) for display at bottom
        $lastRecord = $allPostings->sortByDesc(fn($p) => $p->journalEntry->date)->first();
        if ($lastRecord) {
            $lastRecord->running_balance = $closing; // total closing
        }

        return [
            'opening' => $opening,
            'postings' => $postings,
            'closing' => $closing,
            'lastRecord' => $lastRecord,
            'from' => $from,
            'to' => $to,
        ];
    }

    // INCOME & EXPENSE REPORT
    public function incomeExpense($from, $to, $perPage)
    {
        $from = $from ? Carbon::parse($from) : now()->startOfMonth();
        $to   = $to ? Carbon::parse($to)->endOfDay() : now()->endOfMonth();

        $accounts = Account::whereIn('type', ['revenue', 'expense'])
            ->paginate($perPage);

        $data = $accounts->map(function ($acc) use ($from, $to) {

            $debit = JournalPosting::join('journal_entries', 'journal_entries.id', '=', 'journal_postings.journal_entry_id')
                ->where('account_id', $acc->id)
                ->whereBetween('date', [$from, $to])
                ->sum('debit');

            $credit = JournalPosting::join('journal_entries', 'journal_entries.id', '=', 'journal_postings.journal_entry_id')
                ->where('account_id', $acc->id)
                ->whereBetween('date', [$from, $to])
                ->sum('credit');

            return [
                'name' => $acc->name,
                'type' => $acc->type,
                'debit' => $debit,
                'credit' => $credit,
                'net' => $credit - $debit,
            ];
        });

        return compact('data', 'accounts', 'from', 'to');
    }

    // TRIAL BALANCE
    public function trialBalance($from, $to, $perPage)
    {
        $from = $from ? Carbon::parse($from) : now()->startOfMonth();
        $to   = $to ? Carbon::parse($to)->endOfDay() : now()->endOfMonth();

        $accounts = Account::paginate($perPage);

        $data = $accounts->map(function ($acc) use ($from, $to) {

            $debit = JournalPosting::join('journal_entries', 'journal_entries.id', '=', 'journal_postings.journal_entry_id')
                ->where('account_id', $acc->id)
                ->whereBetween('date', [$from, $to])
                ->sum('debit');

            $credit = JournalPosting::join('journal_entries', 'journal_entries.id', '=', 'journal_postings.journal_entry_id')
                ->where('account_id', $acc->id)
                ->whereBetween('date', [$from, $to])
                ->sum('credit');

            return [
                'name'   => $acc->name,
                'type'   => $acc->type,
                'debit'  => $debit,
                'credit' => $credit,
                'balance' => $debit - $credit,
            ];
        });

        return compact('accounts', 'data', 'from', 'to');
    }
}
