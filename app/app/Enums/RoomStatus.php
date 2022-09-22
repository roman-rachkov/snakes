<?php

declare(strict_types=1);

namespace App\Enums;

enum RoomStatus: string
{
    case OPEN = 'Open';
    case CLOSED = 'Closed';
    case FINISHED = 'Finished';
    case CANCELED = 'Canceled';

    public static function arrayValues(): array
    {
        return collect(self::cases())->map(fn($item) => $item->value)->toArray();
    }

}
