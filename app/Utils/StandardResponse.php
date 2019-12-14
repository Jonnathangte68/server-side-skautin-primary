<?php

namespace App\Utils;

class StandardResponse
{
    function __construct(bool $status, String $message) {
        return $message;
    }
}
