<?php

namespace App\Http\Repository;

use App\Models\Student;

class StudentRepository 
{
    protected $model;
    public function __construct(Student $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        $data = $this->model->create($data);
        return $data;
    }
}