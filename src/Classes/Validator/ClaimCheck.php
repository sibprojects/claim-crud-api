<?php

namespace App\Classes\Validator;

interface ClaimCheck
{
    public static function validate($value): bool;
}