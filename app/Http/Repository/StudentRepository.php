<?php

namespace App\Http\Repository;

use App\Models\Student;
use Exception;

class StudentRepository
{
    protected $model;
    public function __construct(Student $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        try {
            $createData = $this->model->create($data);
            return $createData;
        } catch (Exception $e) {
            return back()->with('error', 'Something want wrong!');
        }
    }

    public function update(int $id, array $data)
    {
        try {
            $student = $this->model->findOrFail($id);
            $student->update($data);
            return $student;
        } catch (Exception $e) {
            return back()->with('error', 'Something want wrong!');
        }
    }

    public function delete(int $id)
    {
        try {
            $student = $this->model->findOrFail($id);
            $student->delete();
            return true;
        } catch (Exception $e) {
            return back()->with('error', 'Something want wrong!');
        }
    }
}
