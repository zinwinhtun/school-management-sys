<?php

namespace App\Models;

use App\Models\JournalPosting;
use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    protected $table = 'journal_entries';

    protected $fillable = [
        'reference_id',
        'reference_type',
        'date',
        'description',
    ];

    public function reference()
    {
        return $this->morphTo();
    }

    public function postings()
    {
        return $this->hasMany(JournalPosting::class);
    }

    //Auto check balance
    public function isBalanced()
    {
        return $this->postings->sum('debit') === $this->postings->sum('credit');
    }

    protected $casts = [
        'date' => 'datetime',
    ];
}
