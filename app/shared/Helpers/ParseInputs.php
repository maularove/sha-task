<?php

namespace App\Shared\Helpers;

class ParseInputs
{
    public static function parseSwitchButton(array $parsedBody, string $switchName): bool
    {
        return isset($parsedBody[$switchName]) && $parsedBody[$switchName] == 'on';
    }
}
