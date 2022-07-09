<?php

namespace App\Classes;

enum AccountType: string
{
    case ORGANIZATION = 'ORGANIZATION';
    case PRIVATE = 'PRIVATE';

    public static function getTypes(): array
    {
        return array_column(self::cases(), 'value');
    }
}
