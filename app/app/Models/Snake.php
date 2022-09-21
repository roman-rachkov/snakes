<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $intelligence
 * @property int $endurance
 * @property int $level
 * @property int $strength
 * @property int $dexterity
 */
class Snake extends Model
{
    use HasFactory;

    protected $fillable = [
        'strength',
        'dexterity',
        'endurance',
        'intelligence',
        'user_id',
        'snake_type_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function snakeType(): BelongsTo
    {
        return $this->belongsTo(SnakeType::class);
    }

    public static function makeSnake(User $user, SnakeType $snakeType)
    {
        $snake = static::create([
            'strength' => $snakeType->strength,
            'dexterity' => $snakeType->dexterity,
            'endurance' => $snakeType->endurance,
            'intelligence' => $snakeType->intelligence,
            'snake_type_id' => $snakeType->id,
            'user_id' => $user->id
        ]);

    }

    public function level(): Attribute
    {
        return Attribute::make(
            get: fn() => 1
        );
    }

    public function maxLife(): Attribute
    {
        return Attribute::make(
            get: fn() => 5 * $this->level + 3 * $this->endurance
        );
    }

    public function maxMana(): Attribute
    {
        return Attribute::make(
            get: fn() => 5 * $this->level + 3 * $this->intelligence
        );
    }

    public function attack(): Attribute
    {
        return Attribute::make(
            get: fn() => 2 * $this->strength
        );
    }

    public function defence(): Attribute
    {
        return Attribute::make(
            get: fn() => 1.5 * $this->strength
        );
    }

    public function accuracy(): Attribute
    {
        return Attribute::make(
            get: fn() => 2 * $this->dexterity
        );
    }

    public function dodge(): Attribute
    {
        return Attribute::make(
            get: fn() => 1.5 * $this->dexterity
        );
    }
}
