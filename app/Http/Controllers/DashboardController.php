<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\Student;
use App\Models\BookSell;
use App\Models\Expenses;
use App\Models\ClassType;
use Illuminate\Http\Request;
use App\Models\JournalPosting;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Pages.dashboard', [
            'totalStudents'          => Student::count(),
            'feeThisMonth'           => $this->getMonthlyNetFee(),
            'bookRevenueThisMonth'   => $this->getBookRevenue(),
            'totalExpensesThisMonth' => $this->getMonthlyExpenses(),
            'feeLabels'              => $this->getFeeLabels('month'),
            'feeTrend'               => $this->getFeeTrend('month'),
            'classes'                => ClassType::pluck('name')->toArray(),
            'studentCounts'          => ClassType::withCount('students')->pluck('students_count')->toArray(),
        ]);
    }

    /* -------------------------------------------------------------
        MONTHLY SUMMARY CARDS
    --------------------------------------------------------------*/

    private function getMonthlyNetFee()
    {
        $revenue = $this->accountCredit('4001', now()->month);
        $refund  = $this->accountDebit('2002', now()->month);

        return $revenue - $refund;
    }

    private function getBookRevenue()
    {
        return BookSell::whereMonth('created_at', now()->month)->sum('total_price');
    }

    private function getMonthlyExpenses()
    {
        return Expenses::whereMonth('created_at', now()->month)->sum('amount');
    }

    /* -------------------------------------------------------------
        CHART: FEE TREND
    --------------------------------------------------------------*/

    public function feeChart(Request $req)
    {
        $range = $req->range;

        return [
            'labels' => $this->getFeeLabels($range),
            'data'   => $this->getFeeTrend($range)
        ];
    }

    private function getFeeLabels($range)
    {
        return match ($range) {
            'week' => ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
            'year' => ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            default => range(1, now()->daysInMonth),
        };
    }

    private function getFeeTrend($range)
    {
        $revenue = $this->postings('4001');
        $refund  = $this->postings('2002');

        return match ($range) {
            'week' => $this->trendWeek($revenue, $refund),
            'year' => $this->trendYear($revenue, $refund),
            default => $this->trendMonth($revenue, $refund),
        };
    }

    /* WEEKLY TREND */
    private function trendWeek($revQuery, $refQuery)
    {
        $start = now()->startOfWeek();
        $end   = now()->endOfWeek();

        $rev = $this->groupTrend($revQuery, $start, $end, 'DAYOFWEEK', 'credit');
        $ref = $this->groupTrend($refQuery, $start, $end, 'DAYOFWEEK', 'debit');

        return $this->subtractTrend($rev, $ref, 7);
    }

    /* MONTHLY TREND */
    private function trendMonth($revQuery, $refQuery)
    {
        $month = now()->month;

        $rev = $this->groupMonth($revQuery, $month, 'credit');
        $ref = $this->groupMonth($refQuery, $month, 'debit');

        return $this->subtractTrend($rev, $ref, now()->daysInMonth);
    }

    /* YEARLY TREND */
    private function trendYear($revQuery, $refQuery)
    {
        $rev = $this->groupYear($revQuery, 'credit');
        $ref = $this->groupYear($refQuery, 'debit');

        return $this->subtractTrend($rev, $ref, 12);
    }

    /* Helpers for grouped queries */
    private function groupTrend($query, $start, $end, $format, $column)
    {
        return $query->whereHas('journalEntry', fn($q) =>
            $q->whereBetween('date', [$start, $end])
        )
            ->selectRaw("$format(created_at) as x, SUM($column) as total")
            ->groupBy('x')
            ->pluck('total', 'x')
            ->toArray();
    }

    private function groupMonth($query, $month, $column)
    {
        return $query->whereHas('journalEntry', fn($q) =>
            $q->whereMonth('date', $month)
        )
            ->selectRaw("DAY(created_at) as x, SUM($column) as total")
            ->groupBy('x')
            ->pluck('total', 'x')
            ->toArray();
    }

    private function groupYear($query, $column)
    {
        return $query->whereHas('journalEntry', fn($q) =>
            $q->whereYear('date', now()->year)
        )
            ->selectRaw("MONTH(created_at) as x, SUM($column) as total")
            ->groupBy('x')
            ->pluck('total', 'x')
            ->toArray();
    }

    private function subtractTrend($rev, $ref, $length)
    {
        return array_map(fn($i) =>
            ($rev[$i] ?? 0) - ($ref[$i] ?? 0),
        range(1, $length));
    }

    /* -------------------------------------------------------------
        ACCOUNT POSTING HELPERS
    --------------------------------------------------------------*/

    private function postings($code)
    {
        return JournalPosting::whereHas('account', fn($q) => $q->where('code', $code));
    }

    private function accountCredit($code, $month)
    {
        return $this->postings($code)
            ->whereHas('journalEntry', fn($q) => $q->whereMonth('date', $month))
            ->sum('credit');
    }

    private function accountDebit($code, $month)
    {
        return $this->postings($code)
            ->whereHas('journalEntry', fn($q) => $q->whereMonth('date', $month))
            ->sum('debit');
    }

    /* -------------------------------------------------------------
        CLASS CHART
    --------------------------------------------------------------*/

    public function classChart(Request $req)
    {
        return [
            'labels' => ClassType::pluck('name')->toArray(),
            'data'   => ClassType::withCount('students')->pluck('students_count')->toArray()
        ];
    }
}
