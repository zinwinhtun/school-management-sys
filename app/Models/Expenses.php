<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    protected $table = 'expenses';

    protected $fillable = [
        'user_id',
        'title',
        'amount',
        'note',
    ];
}
