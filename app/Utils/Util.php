<?php

namespace App\Utils;

class Util
{
    public function parseStringToArray($stringArray) {
        $parsed = json_decode($stringArray);
        if ($parsed) {
            return $parsed;
        }
        // Last try return eval -- insecure
        return eval($stringArray);
    }

    public function getValueByArrayIndexOrReplace($array, $index, $replace) {
        // Works only for PHP7
        $returnValue = $array[$index] ?? $replace;
        if($returnValue) {
            return $returnValue;
        }
        // Find needle and look up to array
        // https://www.php.net/manual/en/function.array-search.php
        $key = array_search($index, $array);
        if($key) {
            return $index[$key];
        }
        // Not found return the replace value
        return $replace;
    }
}
