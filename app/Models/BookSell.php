<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookSell extends Model
{
    protected $table = 'book_sell';

    protected $fillable = [
        'book_id',
        'student_id',
        'quantity',
        'total_price',
    ];
}
