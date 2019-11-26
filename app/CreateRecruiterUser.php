<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Utils\Logger;
use App\Factories\RecruiterFactory;

class CreateRecruiterUser extends Model
{
    // Return: true or false in case stored satisfactory or not.
    public function store(Array $input) 
    {
        $factory = new RecruiterFactory;
        return $factory->createRecruiter($input);
    }
}
