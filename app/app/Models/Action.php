<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Action extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function turn(): BelongsTo
    {
        return $this->belongsTo(Turn::class);
    }

    public function caster(): BelongsTo
    {
        return $this->belongsTo(Snake::class, 'caster_id');
    }

    public function target(): BelongsTo
    {
        return $this->belongsTo(Snake::class, 'target_id');
    }

}
