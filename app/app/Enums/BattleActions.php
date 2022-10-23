<?php

declare(strict_types=1);

namespace App\Enums;

enum BattleActions: string
{
    case ATTACK = 'attack';
    case DEFEND = 'defend';
    case CAST = 'cast';
    case NONE = 'none';

    public static function arrayValues(): array
    {
        return collect(self::cases())->map(fn($item) => $item->value)->toArray();
    }
}
