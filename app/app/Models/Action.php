<?php

namespace App\Models;

use App\Enums\BattleActions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property BattleActions $action
 * @property string $direction
 * @property Snake $target
 * @property Snake $caster
 */
class Action extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'action' => BattleActions::class,
    ];

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
