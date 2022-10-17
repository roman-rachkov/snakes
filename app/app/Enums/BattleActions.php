<?php

declare(strict_types=1);

namespace App\Enums;

enum BattleActions: string
{
    case ATTACK = 'Attack';
    case DEFEND = 'Defend';
    case CAST = 'Cast';

    public static function arrayValues(): array
    {
        return collect(self::cases())->map(fn($item) => $item->value)->toArray();
    }
}
