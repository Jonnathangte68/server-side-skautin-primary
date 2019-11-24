<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Utils\Logger;
use App\Factories\TalentFactory;

class CreateTalentUser extends Model
{
    // Return: true or false in case stored satisfactory or not.
    public function store(Array $input) 
    {
        $factory = new TalentFactory;
        return $factory->createTalent($input);
    }
}
