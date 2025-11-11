<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Repository\ExpenseRepository;
use App\Http\Requests\Expense\CreateRequest;
use App\Http\Requests\Expense\UpdateRequest;
use App\Models\Expenses;

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
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();
            $this->expenseRepo->create($data);
            return redirect()->route('expenses.index')->with('success', 'Expense created successfully.');
        } catch (\Exception $e) {
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
        $expense = Expenses::find($id);
        return view('Pages.Expense.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        try {
            $validate = $request->validated();
            $validate['user_id'] = Auth::id();
            $this->expenseRepo->update($validate,$id);
            return redirect()->route('expenses.index')->with('success', 'Expense Updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->expenseRepo->delete($id);
        return redirect()->route('expenses.index')->with('success', 'Expense Deleted successfully.');
    }
}
