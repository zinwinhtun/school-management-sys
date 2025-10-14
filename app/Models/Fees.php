<?php

namespace App\Models;

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
}
