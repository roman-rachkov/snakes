<?php

declare(strict_types=1);

use Illuminate\Support\Collection;

if (!function_exists('translations')) {
    function translations(string $json)
    {
        if (!file_exists($json)) {
            return [];
        }
        return json_decode(file_get_contents($json));
    }
}

if (!function_exists('rollDice')) {
    function rollDice(string $dicePattern): Collection
    {
        if (!preg_match('/^[0-9]*d[0-9]+$/i', $dicePattern)) {
            throw new \http\Exception\InvalidArgumentException('Wrong dice pattern');
        }
        list($count, $diceType) = explode('d', $dicePattern);

        $dices = [];
        for ($i = 1; $i <= max((int)$count, 1); $i++) {
            $dices[] = rand(1, max((int)$diceType, 1));
        }
        return collect($dices);
    }
}

if (!function_exists('getSumRolledDices')) {
    function getSumRolledDices(string $dicePattern = '1d6'): int
    {
        return rollDice($dicePattern)->sum();
    }
}
