<?php

namespace App\Models;

use App\Models\Student;
use App\Models\ClassType;
use App\Models\FeeHistory;
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
        'full_paid',
    ];


    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassType::class, 'class_id');
    }

    public function fee_history()
    {
        return $this->hasMany(FeeHistory::class , 'fee_id');
    }
}
