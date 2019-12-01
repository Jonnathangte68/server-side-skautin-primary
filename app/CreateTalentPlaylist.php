<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Factories\TalentPlaylistFactory;

class CreateTalentPlaylist
{
    // Return: true or false in case stored satisfactory or not.
    public function store(Array $input) 
    {
        $factory = new TalentPlaylistFactory;
        return $factory->createPlaylist($input);
    }
}
