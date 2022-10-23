<?php

declare(strict_types=1);

namespace App\Enums;

enum RoomStatus: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case FIGHT = 'fight';
    case FINISHED = 'finished';
    case CANCELED = 'canceled';

    public static function arrayValues(): array
    {
        return collect(self::cases())->map(fn($item) => $item->value)->toArray();
    }

}
