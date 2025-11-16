<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repository\ReportRepository;

class ReportController extends Controller
{
    protected $report_repo;

    public function __construct(ReportRepository $report_repo)
    {
        $this->report_repo = $report_repo;
    }

    public function index()
    {
        return view('Pages.Report.index');
    }

     // CASHBOOK
    public function cashbook(Request $req)
    {
        $data = $this->report_repo->cashbook($req->from, $req->to, 5);
        return view('Pages.Report.cashbook', $data);
    }

    // INCOME REPORT
    public function income(Request $req)
    {
        $data = $this->report_repo->incomeExpense($req->from, $req->to, 6);
        return view('Pages.Report.income', $data);
    }

    // TRIAL BALANCE
    public function trial(Request $req)
    {
        $data = $this->report_repo->trialBalance($req->from, $req->to, 5);
        return view('Pages.Report.trial', $data);
    }
}
