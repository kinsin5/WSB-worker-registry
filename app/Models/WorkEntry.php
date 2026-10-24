<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkEntry extends Model
{
    protected $fillable = [
        'user_id',
        'work_date',
        'hours',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'work_date' => 'date',
            'hours' => 'decimal:2',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(WorkEntryComment::class);
    }
}
