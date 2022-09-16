<?php

declare(strict_types=1);


function translations(string $json)
{
    if (!file_exists($json)) {
        return [];
    }
    return json_decode(file_get_contents($json));
}
