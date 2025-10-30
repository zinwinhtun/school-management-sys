<?php

namespace App\Models;

use App\Models\BookSell;
use App\Models\ClassType;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $fillable = [
        'name',
        'phone',
        'address',
        'parent_name',
        'date_of_birth',
        'class_id',
    ];


    public function classType()
    {
        return $this->belongsTo(ClassType::class, 'class_id');
    }

    public function bookSells()
    {
        return $this->hasMany(BookSell::class, 'student_id');
    }
}
