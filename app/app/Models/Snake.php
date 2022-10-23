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
 * @property int $current_hp
 * @property int $max_life
 * @property int $current_mp
 * @property int $max_mana
 * @property float $dodge
 * @property float $defence
 * @property int $accuracy
 * @property int $attack
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

    protected $appends = [
        'level',
        'max_life',
        'max_mana',
        'attack',
        'defence',
        'accuracy',
        'dodge'
    ];

    protected $with = ['snakeType'];

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

        $snake->current_hp = $snake->max_life;
        $snake->current_mp = $snake->max_mana;
        $snake->save();
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

    public function isLife(): Attribute
    {
        return new Attribute(
            get: fn() => $this->current_hp > 0,
        );
    }
}
