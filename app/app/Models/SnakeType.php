<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $intelligence
 * @property int $endurance
 * @property int $dexterity
 * @property int $strength
 */
class SnakeType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'strength',
        'dexterity',
        'endurance',
        'intelligence',
    ];

    public function snakes(): HasMany
    {
        return $this->hasMany(Snake::class);
    }
}
