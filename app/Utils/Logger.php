<?php

namespace App\Utils;

class Logger
{
    function __construct($message) {
        error_log($message);
    }
}
