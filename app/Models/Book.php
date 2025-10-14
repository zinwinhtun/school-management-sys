<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'category',
        'class_id',
        'purchase_price',
        'sale_price',
        'stock',
    ];
}
