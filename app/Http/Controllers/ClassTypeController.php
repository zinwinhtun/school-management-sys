<?php

namespace App\Http\Controllers;

use App\Http\Repository\StudentRepository;
use App\Models\ClassType;
use Illuminate\Http\Request;

class ClassTypeController extends Controller
{
    protected $model;

    public function __construct(ClassType $model)
    {
        $this->model = $model;
    }

    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'name' => 'required|unique:class_types,name|min:3|max:100',
            ]);
            $this->model->create($validate);

            session()->flash('toastr', [
                'type' => 'success',
                'message' => 'Class successfully!'
            ]);

            return back()->with('success', 'Class created successfully!');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }
}
