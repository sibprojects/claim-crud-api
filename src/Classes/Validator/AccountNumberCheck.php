<?php

namespace App\Classes\Validator;

class AccountNumberCheck implements ClaimCheck
{
    public static function validate($value): bool
    {
        //Get Last Number
        $checkDigit = (int)substr($value, -1);
        //Get Remaining Numbers
        $numbers = substr($value, 0, -1);
        // Sort Numbers Into an Array
        $numbers_array = str_split($numbers);
        //Define the base for the weights
        $base=2;
        // Multiply the weights to the numbers
        $numbers_array_reversed =  array_reverse($numbers_array);
        foreach($numbers_array_reversed as $number){$multiplier[$number.'x'.$base]=(float)$number * $base;$base++;}
        //Get the total sum
        $sum =(float) array_sum($multiplier);
        $modulus = 11;
        // Divide the sum by check digit 11
        $divider = (float)($sum / $modulus);
        // Get the remainder
        $remainder = (int)(($divider - (int)$divider)*$modulus);
        // Check if the remainder is matching with the last check digit
        $results = (int) ($modulus-$remainder);
        // Return true or false
        return ($results == $checkDigit ? true : false);
    }
}