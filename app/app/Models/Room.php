<?php

namespace App\Models;

use App\Enums\RoomStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    use HasFactory;

    public function open(Builder $builder, Model $model)
    {
        $builder->whereNotIn('status', [RoomStatus::CANCELED, RoomStatus::FINISHED]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
