<?php

namespace App\Models;

use App\Models\Fees;
use Illuminate\Database\Eloquent\Model;

class FeeHistory extends Model
{
    protected $table = 'fee_histories';

    protected $fillable = [
        'fee_id',
        'amount',
        'type',
        'note'
    ];


    public function fee()
    {
        return $this->belongsTo(Fees::class, 'fee_id');
    }
}
