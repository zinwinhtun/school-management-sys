<?php

namespace App\Models;

use App\Models\BookSell;
use App\Models\ClassType;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'name',
        'category',
        'class_id',
        'purchase_price',
        'sell_price',
        'stock',
    ];

    public function classType()
    {
        return $this->belongsTo(ClassType::class, 'class_id');
    }

    public function bookSells()
    {
        return $this->hasMany(BookSell::class, 'book_id');
    }
}
