<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BattleLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function turn(): BelongsTo
    {
        return $this->belongsTo(Turn::class);
    }

}
