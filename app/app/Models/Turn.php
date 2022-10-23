<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Collection $actions
 * @property Collection $logs
 */
class Turn extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['actions', 'logs'];

    public function actions(): HasMany
    {
        return $this->hasMany(Action::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(BattleLog::class);
    }
}
