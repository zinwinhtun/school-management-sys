<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\CreateRequest;
use App\Http\Requests\Student\UpdateRequest;
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
        $classes = ClassType::get();
        return view('Pages.Student.create', compact('classes'));
    }

    public function store(CreateRequest $request)
    {
        try {
            $data = $request->validated();
            $this->model->create($data);
            return redirect()->route('student.index')->with('success', 'Student created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('student.index')->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $student = $this->model->findOrFail($id);
        $classes = ClassType::get();
        return view('Pages.Student.edit', compact('student', 'classes'));
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $student = $this->model->findOrFail($id);
            $data = $request->validated();
            $student->update($data);
            return redirect()->route('student.index')->with('success', 'Student updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('student.index')->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $student = $this->model->findOrFail($id);
            $student->delete();
            return redirect()->route('student.index')->with('success', 'Student deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('student.index')->with('error', $e->getMessage());
        }
    }
}
