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

    public function gen_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
    
            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),
    
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,
    
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,
    
            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
}
