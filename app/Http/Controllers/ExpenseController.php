<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Repository\ExpenseRepository;
use App\Http\Requests\Expense\CreateRequest;

class ExpenseController extends Controller
{

    protected $expenseRepo;

    public function __construct(ExpenseRepository $expenseRepo)
    {
        $this->expenseRepo = $expenseRepo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $expenses = $this->expenseRepo->all($search);
        return view('Pages.Expense.index', compact('expenses', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Pages.Expense.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        try{
            $data = $request->validated();
            $data['user_id'] = Auth::id();
            $this->expenseRepo->create($data);
            return redirect()->route('expenses.index')->with('success', 'Expense created successfully.');
        }catch(\Exception $e) {
            return redirect()->route('expenses.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
