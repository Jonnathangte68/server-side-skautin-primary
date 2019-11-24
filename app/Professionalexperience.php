<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Professionalexperience extends Model
{
    use SoftDeletes;

    protected $table = 'professional_experiences';
}
