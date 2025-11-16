<?php

namespace App\Models;

use App\Models\JournalPosting;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';

    protected $fillable = [
        'name',
        'code',
        'type', // asset, liability, equity, revenue, expense
        'parent_id'
    ];

    public function journalPostings()
    {
        return $this->hasMany(JournalPosting::class);
    }
}
