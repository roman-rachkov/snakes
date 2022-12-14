<?php

declare(strict_types=1);

namespace App\Enums;

enum RoomMode: string
{
    case DEATHMATCH = 'deathmatch';
    case TEAM = 'team';

    public static function arrayValues(): array
    {
        return collect(self::cases())->map(fn($item) => $item->value)->toArray();
    }
}
