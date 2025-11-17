<?php

namespace App\Models;

use App\Models\JournalEntry;
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

    public function journalEntries()
    {
        return $this->hasManyThrough(
            JournalEntry::class,
            JournalPosting::class,
            'account_id',         // journal_postings.account_id
            'id',                 // journal_entries.id
            'id',                 // accounts.id
            'journal_entry_id'    // journal_postings.journal_entry_id
        );
    }
}
