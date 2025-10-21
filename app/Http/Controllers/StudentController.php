<?php

namespace App\Http\Controllers;

use App\Models\ClassType;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $model;

    public function __construct(Student $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $query = $this->model->with('classType');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('parent_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhereHas('classType', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $students = $query->paginate(5);

        return view('Pages.Student.index', compact('students'));
    }

    public function create()
    {
        $classes = ClassType::all();
        return view('Pages.Student.create',compact('classes'));
    }
}
