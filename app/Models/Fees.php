<?php

namespace App\Models;

use App\Models\Student;
use App\Models\ClassType;
use Illuminate\Database\Eloquent\Model;

class Fees extends Model
{
    protected $table = 'fees';

    protected $fillable = [
        'student_id',
        'class_id',
        'title',
        'total_amount',
        'paid_amount',
        'description',
        'full_paid',
        'is_refunded'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassType::class, 'class_id');
    }
}
