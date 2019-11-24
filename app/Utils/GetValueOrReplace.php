<?php

namespace App\Utils;

class GetValueOrReplace
{
    function __construct($array, $index, $replace) {
        // Works only for PHP7
        return $array[$index] ?? $replace;
    }
}
