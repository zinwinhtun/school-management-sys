<?php

namespace App\Http\Repository;

use App\Models\Expenses;
use Exception;

class ExpenseRepository {

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
        try{
            return $this->model::create($data);
        }catch(\Exception $e) {
            return redirect()->route('expenses.index')->with('error', $e->getMessage());
        }
    }

}