<?php

namespace App\Models;

use App\Models\Book;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class ClassType extends Model
{
    protected $table = 'class_types';

    protected $fillable = [
        'name',
    ];

    public function students()
    {
        return $this->hasMany(Student::class , 'class_id');
    }

    public function books()
    {
        return $this->hasMany(Book::class, 'class_id');
    }
}
