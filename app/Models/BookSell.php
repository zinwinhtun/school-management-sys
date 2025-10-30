<?php

namespace App\Models;

use App\Models\Book;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class BookSell extends Model
{
    protected $table = 'book_sells';

    protected $fillable = [
        'book_id',
        'student_id',
        'quantity',
        'total_price',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
