<?php

namespace App\Models;

use App\Enums\RoomStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 */
class Room extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
//        'user_id' => User::class
    ];

    public function scopeOpen(Builder $builder)
    {
        return $builder->whereNotIn('status', [RoomStatus::CANCELED, RoomStatus::FINISHED]);
    }

    public function scopeWait(Builder $builder)
    {
        return $builder->whereNotIn('status', [RoomStatus::CANCELED, RoomStatus::FINISHED, RoomStatus::FIGHT]);
    }

    public function isFull(): Attribute
    {
        return new Attribute(
            get: fn() => $this->users->count() === $this->max_players
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
}
