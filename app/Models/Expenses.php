<?php

namespace App\Models;

use App\Models\User;
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
