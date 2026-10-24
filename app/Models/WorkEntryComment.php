<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkEntryComment extends Model
{
    protected $fillable = [
        'work_entry_id',
        'user_id',
        'content',
    ];

    public function workEntry(): BelongsTo
    {
        return $this->belongsTo(WorkEntry::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
