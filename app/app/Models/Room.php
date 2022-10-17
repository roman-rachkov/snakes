<?php

namespace App\Models;

use App\Enums\RoomStatus;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property bool $isFull
 * @property Turn $current_turn
 * @property Collection $turns
 */
class Room extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
//        'user_id' => User::class

    ];

    protected $appends = [
        'min_level',
        'max_level',
        'current_players',
        'is_full',
        'current_turn',
        'next_turn_in'
    ];

    protected $with = ['turns'];

    public function scopeOpen(Builder $builder)
    {
        return $builder->whereNotIn('status', [RoomStatus::CANCELED, RoomStatus::FINISHED]);
    }

    public function scopeWait(Builder $builder)
    {
        return $builder->whereNotIn('status', [RoomStatus::CANCELED, RoomStatus::FINISHED, RoomStatus::FIGHT]);
    }

    public function scopeInFight(Builder $builder)
    {
        return $builder->where('status', RoomStatus::FIGHT);
    }

    public function nextTurnIn(): Attribute
    {
        return new Attribute(
            get: fn() => $this->updated_at->addSeconds(30),
        );
    }

    public function isFull(): Attribute
    {
        return new Attribute(
            get: fn() => $this->users->count() >= $this->max_players
        );
    }

    public function minLevel(): Attribute
    {
        return new Attribute(
            get: fn() => max(1, $this->user->snake->level - config('main.min_level', 2))
        );
    }

    public function maxLevel(): Attribute
    {
        return new Attribute(
            get: fn() => $this->user->snake->level + config('main.max_level', 2)
        );
    }

    public function currentPlayers(): Attribute
    {
        return new Attribute(
            get: fn() => $this->users->count()
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): BelongsToMany
    {
        return $this->BelongsToMany(User::class);
    }

    public function turns(): HasMany
    {
        return $this->hasMany(Turn::class);
    }

    public function currentTurn(): Attribute
    {
        return new Attribute(
            get: fn() => $this->turns()->where('ended', false)->first(),
        );
    }

}
